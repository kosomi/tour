<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$view_skin_url.'/view.css" media="screen">', 0);

$attach_list = '';
if ($view['link']) {
    // 링크
    for ($i=1; $i<=count($view['link']); $i++) {
        if ($view['link'][$i]) {
            $attach_list .= '<a class="list-group-item break-word" href="'.$view['link_href'][$i].'" target="_blank">';
            $attach_list .= '<i class="fa fa-link"></i> '.cut_str($view['link'][$i], 70).' &nbsp;<span class="blue">+ '.$view['link_hit'][$i].'</span></a>'.PHP_EOL;
        }
    }
}

// 가변 파일
$j = 0;
if ($view['file']['count']) {
    for ($i=0; $i<count($view['file']); $i++) {
        if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
            if ($board['bo_download_point'] < 0 && $j == 0) {
                $attach_list .= '<a class="list-group-item"><i class="fa fa-bell red"></i> 다운로드시 <b>'.number_format(abs($board['bo_download_point'])).'</b>'.AS_MP.' 차감 (최초 1회 / 재다운로드시 차감없음)</a>'.PHP_EOL;
            }
            $file_tooltip = '';
            if($view['file'][$i]['content']) {
                $file_tooltip = ' data-original-title="'.strip_tags($view['file'][$i]['content']).'" data-toggle="tooltip"';
            }
            $attach_list .= '<a class="list-group-item break-word view_file_download at-tip" href="'.$view['file'][$i]['href'].'"'.$file_tooltip.'>';
            $attach_list .= '<span class="pull-right hidden-xs text-muted"><i class="fa fa-clock-o"></i> '.date("Y.m.d H:i", strtotime($view['file'][$i]['datetime'])).'</span>';
            $attach_list .= '<i class="fa fa-download"></i> '.$view['file'][$i]['source'].' ('.$view['file'][$i]['size'].') &nbsp;<span class="orangered">+ '.$view['file'][$i]['download'].'</span></a>'.PHP_EOL;
            $j++;
        }
    }
}

        $view_font = (G5_IS_MOBILE) ? '' : ' font-12';
        $view_subject = get_text($view['wr_subject']);

        $ex1_filed = explode("|",$view['wr_1']); // 여분필드 쪼개기
        // 작성자정보 //
        $ext1_00  = $ex1_filed[0]; // 이름(상호명)
        $ext1_01  = $ex1_filed[1]; // 이메일
        $ext1_02  = $ex1_filed[2]; // 전화번호
        $ext1_03  = $ex1_filed[3]; // 휴대폰
        // 사이트정보 //
        $ext1_04  = $ex1_filed[4]; // 사이트주소
        $ext1_05  = $ex1_filed[5]; // 형태
        $ext1_06  = $ex1_filed[6]; // 운영방식
        $ext1_07  = $ex1_filed[7]; // 구축방식
        $ext1_08  = $ex1_filed[8]; // 전체회원
        $ext1_09  = $ex1_filed[9]; // 일방문자
        $ext1_10  = $ex1_filed[10]; // 월매출
        $ext1_11  = $ex1_filed[11]; // 월순수익
        $ext1_12  = $ex1_filed[12]; // 거래상황
        $ext1_13  = $ex1_filed[13]; // 판매가격
        $ext1_14  = $ex1_filed[14]; // 가격참조

        $nohttp = substr($ext1_04, 7, 100); // 사이트주소 http:// 제거

        // 게시글보기 썸네일 생성
        function get_thumbnail($bo_table, $img, $width, $height=0, $alt, $view=0)
        { 
            $str = '';

            $file = G5_DATA_PATH.'/file/'.$bo_table.'/'.$img;
            if(is_file($file))
                $size = @getimagesize($file);


            if($size[2] < 1 || $size[2] > 3)
                return '';

            $img_width = $size[0];
            $img_height = $size[1];
            $filename = basename($file);
            $filepath = dirname($file);

            if($img_width && !$height) {
                $height = round(($width * $img_height) / $img_width);
            } 
            $thumb = thumbnail($filename, $filepath, $filepath, $width, $height, false, false, 'center', true, $um_value='80/0.5/3');

            if($thumb) {
                $file_url = str_replace(G5_PATH, G5_URL, $filepath.'/'.$thumb);
                $str = '<img src="'.$file_url.'" width="'.$width.'" height="'.$height.'" alt="'.$alt.'">';
            }

            if($view == 1) return $str;
        } 

        for($i=0; $i < 10; $i++){
            get_thumbnail($bo_table, $view['file'][$i]['file'], 590, 380, $view['file'][$i]['bf_content'], 1);  
        }; 
?> 
<section itemscope itemtype="http://schema.org/NewsArticle">
    <article itemprop="articleBody">
        <h1 itemprop="headline" content="<?php echo $view_subject;?>">
            <?php if($view['photo']) { ?><span class="talker-photo hidden-xs"><?php echo $view['photo'];?></span><?php } ?>
            <?php echo cut_str(get_text($view['wr_subject']), 70); ?>
        </h1>
        <div class="panel panel-default view-head<?php echo ($attach_list) ? '' : ' no-attach';?>">
            <div class="panel-heading">
                <div class="ellipsis text-muted<?php echo $view_font;?>">
                    <span itemprop="publisher" content="<?php echo get_text($view['wr_name']);?>">
                        <?php echo $view['name']; //등록자 ?>
                    </span>
                    <?php echo ($is_ip_view) ? '<span class="print-hide hidden-xs">('.$ip.')</span>' : ''; ?>
                    <?php if($view['ca_name']) { ?>
                        <span class="hidden-xs">
                            <span class="sp"></span>
                            <i class="fa fa-tag"></i>
                            <?php echo $view['ca_name']; //분류 ?>
                        </span>
                    <?php } ?>
                    <span class="sp"></span>
                    <i class="fa fa-comment"></i>
                    <?php echo ($view['wr_comment']) ? '<b class="red">'.$view['wr_comment'].'</b>' : 0; //댓글수 ?>
                    <span class="sp"></span>
                    <i class="fa fa-eye"></i>
                    <?php echo $view['wr_hit']; //조회수 ?>

                    <?php if($is_good) { ?>
                        <span class="sp"></span>
                        <i class="fa fa-thumbs-up"></i>
                        <?php echo $view['wr_good']; //추천수 ?>
                    <?php } ?>
                    <?php if($is_nogood) { ?>
                        <span class="sp"></span>
                        <i class="fa fa-thumbs-down"></i>
                        <?php echo $view['wr_nogood']; //비추천수 ?>
                    <?php } ?>
                    <span class="pull-right">
                        <i class="fa fa-clock-o"></i>
                        <span itemprop="datePublished" content="<?php echo date('Y-m-dTH:i:s', $view['date']);?>">
                            <?php echo apms_date($view['date'], 'orangered', 'before'); //시간 ?>
                        </span>
                    </span>
                </div>
            </div>
           <?php
                if($attach_list) {
                    echo '<div class="list-group'.$view_font.'">'.$attach_list.'</div>'.PHP_EOL;
                }
            ?>
        </div>

        <div class="view-padding">

            <?php if ($is_torrent) echo apms_addon('torrent-basic'); // 토렌트 파일정보 ?>

            <div itemprop="description" class="view-content">

<!-- 쇼핑몰 정보 시작 -->

<style>
    .rm_grid_1 {width:5%}
    .rm_grid_2 {width:10%}
    .rm_grid_3 {width:15%}
    .rm_grid_4 {width:20%}
    .rm_grid_5 {width:25%}
    .rm_grid_6 {width:30%}
    .rm_grid_7 {width:35%}
    .rm_grid_8 {width:40%}
    .rm_grid_9 {width:45%}
    .rm_grid_10 {width:50%}
    .rm_grid_11 {width:60%}
    .rm_grid_12 {width:65%}
    .rm_grid_13 {width:70%}
    .rm_grid_14 {width:75%}
    .rm_grid_15 {width:80%}
    .rm_grid_16 {width:85%}
    .rm_grid_17 {width:90%}
    .rm_grid_18 {width:95%}
    .empty_table {padding:85px 0 !important;}
    .frm_essential {padding-right:10px; background:url(./img/bg_formEssential.gif) no-repeat 100% 4px;}

    /* 기본설정 */
    table {width:100%;border-collapse:collapse;border-spacing:0;}
    table caption.hidden {overflow:hidden;font-size:0;line-height:0;}
    .st_btn_area {margin:10px 0 0 0;padding:10px 0 9px;border:1px solid #e6e6e6;text-align:center;background:#f5f5f5;}

    .st_view tbody th {padding:8px 0 7px;border:1px solid #e6e6e6;text-align:center;background:#f5f5f5;}
    .st_view tbody th, .st_view tbody td {padding:8px 0 7px;border:1px solid #e6e6e6;text-align:center;font-weight:normal;line-height:1.8em;}
    .st_view tbody td.left {padding-left:10px;text-align:left;border:1px solid #e6e6e6;}

    .st_view_wrap { width:100%; margin:0; }
    .st_view1 { float:left; width:100%; height:auto; }
    .st_thumb { float:left; min-width:300px; width:50%; height:426px; border:1px solid #e6e6e6; overflow:hidden; }
    .st_table { float:left; min-width:300px; width:50%; padding-left:10px; }

    .st_view2 { float:left; min-width:300px;; width:100%; margin-top:10px; margin-bottom:30px; }
</style>

<div class="st_view_wrap">   
    <script src="<?php echo $board_skin_url; ?>/script.js"></script>
    <link rel="stylesheet" href="<?php echo $board_skin_url; ?>/style.css">
    <div class="mara_view_wrap" style="width:<?php echo $width; ?>;"> 
        <div align='center'>
            <div class="photo">
                <?php if($view['file']['0']['file']){ ?>
                    <?php echo get_thumbnail($bo_table, $view['file'][0]['file'], 590, 380, $view['file'][0]['bf_content'], 1); ?>
                <?php } ?>  
                <br><br>
            </div> 

             <div style='background-color: #ECECEC; padding: 20px'>
                 <div id='target'>
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][0]['file'], 118, 90, $view['file'][0]['bf_content'], 1); ?> 
                    </a>
              
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][1]['file'], 118, 90, $view['file'][1]['bf_content'], 1); ?> 
                    </a>
           
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][2]['file'], 118, 90, $view['file'][2]['bf_content'], 1); ?> 
                    </a>
            
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][3]['file'], 118, 90, $view['file'][3]['bf_content'], 1); ?> 
                    </a>  
            
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][4]['file'], 118, 90, $view['file'][4]['bf_content'], 1); ?> 
                    </a>  
                </div> 
                <br>
                <div id='target'>
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][5]['file'], 118, 90, $view['file'][5]['bf_content'], 1); ?> 
                    </a>
              
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][6]['file'], 118, 90, $view['file'][6]['bf_content'], 1); ?> 
                    </a>
           
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][7]['file'], 118, 90, $view['file'][7]['bf_content'], 1); ?> 
                    </a>
            
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][8]['file'], 118, 90, $view['file'][8]['bf_content'], 1); ?> 
                    </a>  
            
                    <a style='padding:10px 10px 10px 10px'>
                        <?php echo get_thumbnail($bo_table, $view['file'][9]['file'], 118, 90, $view['file'][9]['bf_content'], 1); ?> 
                    </a>  
                </div> 
            </div> 
        </div> 
    </div>  

    <div class="st_view2">
        <table>
            <tbody>
                <tr>
                    <td>
                        <h4><b>&nbsp; 매물 정보</b></h4>
                    </td>
                </tr>
            </tbody>
        </table> 
        <table class="st_view">  
            <colgroup>
                <col class="rm_grid_1">
                <col class="rm_grid_4"> 
            </colgroup>
        <tbody> 
            <tr>
                <th scope="row">가격</th>
                <td class="left"> 
                    <strong>$ <?php echo number_format($ext1_08) ?></strong>
                </td> 
            </tr>
            <tr>
                <th scope="row">주소</th>
                <td class="left">
                            <?php echo $ext1_04 ?> 
                </td> 
            </tr> 
            <tr>
                <th scope="row">설명</th>
                <td class="left">
                            <?php echo $ext1_09 ?> 
                </td> 
            </tr>
            <tr>
                <th scope="row">구조</th>
                <td class="left">
                            <?php echo $ext1_10 ?> 
                </td> 
            </tr> 
            <tr>
                <th scope="row">타입</th>
                <td class="left">
                            <?php echo $ext1_12 ?> 
                </td> 
            </tr>  
        </tbody>
        </table>
    </div>
</div>

<div class="clearfix"></div>

<!-- 쇼핑몰 정보 끝 -->

                <?php echo get_view_thumbnail($view['content']); ?>
            </div>

            <?php
                // 이미지 하단 출력
                if($v_img_count && $is_img_tail) {
                    echo '<div class="view-img">'.PHP_EOL;
                    for ($i=0; $i<=count($view['file']); $i++) {
                        if ($view['file'][$i]['view']) {
                            echo get_view_thumbnail($view['file'][$i]['view']);
                        }
                    }
                    echo '</div>'.PHP_EOL;
                }
            ?>
        </div>

        <?php if ($good_href || $nogood_href) { ?>
            <div class="print-hide view-good-box">
                <?php if ($good_href) { ?>
                    <span class="view-good">
                        <a href="#" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'good', 'wr_good'); return false;">
                            <b id="wr_good"><?php echo $view['wr_good']; ?></b>
                            <br>
                            <i class="fa fa-thumbs-up"></i>
                        </a>
                    </span>
                <?php } ?>
                <?php if ($nogood_href) { ?>
                    <span class="view-nogood">
                        <a href="#" onclick="apms_good('<?php echo $bo_table;?>', '<?php echo $wr_id;?>', 'nogood', 'wr_nogood'); return false;">
                            <b id="wr_nogood"><?php echo $view['wr_nogood']; ?></b>
                            <br>
                            <i class="fa fa-thumbs-down"></i>
                        </a>
                    </span>
                <?php } ?>
            </div>
            <p></p>
        <?php } else { //여백주기 ?>
            <div class="h40"></div>
        <?php } ?> 

    </article>
</section>

<?php include_once('./view_comment.php'); ?>



<br>
<br>
<br>
<br>
<br>



<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가
include_once(G5_LIB_PATH.'/thumbnail.lib.php');

// add_stylesheet('css 구문', 출력순서); 숫자가 작을 수록 먼저 출력됨
add_stylesheet('<link rel="stylesheet" href="'.$board_skin_url.'/style.css">', 0);
?>

<script src="<?php echo G5_JS_URL; ?>/viewimageresize.js"></script>

<!-- 게시물 읽기 시작 { --> 

<article id="bo_v" style="width:<?php echo $width; ?>">
    <header>
        <h1 id="bo_v_title" style="font-weight: bold; font-size: 26px;">
            <?php
                echo '<span style="color:#0997ED;">'.$view['ca_name'].'</span> | '; // 분류 출력 끝
                echo cut_str(get_text($view['wr_subject']), 70); // 글제목 출력
            ?>
        </h1>
    </header>

    <?php if ($is_admin){ ?> 
        <section id="bo_v_info">
            <h2>페이지 정보</h2>
            작성자 <strong><?php echo $view['name'] ?><?php if ($is_ip_view) { echo "&nbsp;($ip)"; } ?></strong>
            <span class="sound_only">작성일</span><strong><?php echo date("y-m-d H:i", strtotime($view['wr_datetime'])) ?></strong>
            조회<strong><?php echo number_format($view['wr_hit']) ?>회</strong>
            댓글<strong><?php echo number_format($view['wr_comment']) ?>건</strong>
        </section>
    <?php } ?>

    <?php
        if ($view['file']['count']) {
            $cnt = 0;
            for ($i=0; $i<count($view['file']); $i++) {
                if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
                    $cnt++;
            }
        }
     ?>

    <?php if($cnt) { ?>
    <!-- 첨부파일 시작 { -->
    <section id="bo_v_file">
        <h2>첨부파일</h2>
        <ul>
        <?php
            // 가변 파일
            for ($i=0; $i<count($view['file']); $i++) {
                if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view']) {
         ?>
            <li>
                <a href="<?php echo $view['file'][$i]['href'];  ?>" class="view_file_download">
                    <img src="<?php echo $board_skin_url ?>/img/icon_file.gif" alt="첨부">
                    <strong><?php echo $view['file'][$i]['source'] ?></strong>
                    <?php echo $view['file'][$i]['content'] ?> (<?php echo $view['file'][$i]['size'] ?>)
                </a>
                <span class="bo_v_file_cnt"><?php echo $view['file'][$i]['download'] ?>회 다운로드</span>
                <span>DATE : <?php echo $view['file'][$i]['datetime'] ?></span>
            </li>
        <?php
                }
            }
         ?>
        </ul>
    </section>
    <!-- } 첨부파일 끝 -->
    <?php } ?>

    <?php if ($is_admin){ ?>
        <!-- 게시물 상단 버튼 시작 { -->
        <div id="bo_v_top">
            <?php
                ob_start();
             ?>
            <?php if ($prev_href || $next_href) { ?>
            <ul class="bo_v_nb">
                <?php if ($prev_href) { ?><li><a href="<?php echo $prev_href ?>" class="btn_b01">이전글</a></li><?php } ?>
                <?php if ($next_href) { ?><li><a href="<?php echo $next_href ?>" class="btn_b01">다음글</a></li><?php } ?>
            </ul>
            <?php } ?>

            <ul class="bo_v_com">
                <?php if ($update_href) { ?><li><a href="<?php echo $update_href ?>" class="btn_b01">수정</a></li><?php } ?>
                <?php if ($delete_href) { ?><li><a href="<?php echo $delete_href ?>" class="btn_b01" onclick="del(this.href); return false;">삭제</a></li><?php } ?>
                <?php if ($copy_href) { ?><li><a href="<?php echo $copy_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">복사</a></li><?php } ?>
                <?php if ($move_href) { ?><li><a href="<?php echo $move_href ?>" class="btn_admin" onclick="board_move(this.href); return false;">이동</a></li><?php } ?>
                <?php if ($search_href) { ?><li><a href="<?php echo $search_href ?>" class="btn_b01">검색</a></li><?php } ?>
                <li><a href="<?php echo $list_href ?>" class="btn_b01">목록</a></li>
                <?php if ($reply_href) { ?><li><a href="<?php echo $reply_href ?>" class="btn_b01">답변</a></li><?php } ?>
                <?php if ($write_href) { ?><li><a href="<?php echo $write_href ?>" class="btn_b02">글쓰기</a></li><?php } ?>
            </ul>
            <?php
                $link_buttons = ob_get_contents();
                ob_end_flush();
             ?>
        </div>
        <!-- } 게시물 상단 버튼 끝 -->
    <?php } ?>

    <section id="bo_v_atc">
        <h2 id="bo_v_atc_title">본문</h2>
        <div class="container">
            <div class="row">
                <div class="col-sm-6"> 
 
<script src="http://ochanin.com/js/jquery-1.11.3.min.js"></script>
<script src="http://ochanin.com/js/jquery-migrate-1.2.1.min.js"></script>   
 

<div class="st_view_wrap">   
    <script src="http://ochanin.com/skin/board/houseMarket/script.js"></script> 
    <div class="mara_view_wrap" style="width:100%;"> 
        <div align='center'>
            <div class="photo">
                <img src="http://ochanin.com/data/file/realHouse/thumb-1147502322_zwMoElvx_e9b080e6b4c56d5d7dee90e635b477c7a9bd5e6e_590x380.jpg" width="590" height="380" alt="">
                <br><br>
            </div> 

             <div style='background-color: #ECECEC; padding: 20px'>
                 <div id='target'>
                    <a style='padding:10px 10px 10px 10px'>
                        <img src="http://ochanin.com/data/file/realHouse/thumb-1147502322_zwMoElvx_e9b080e6b4c56d5d7dee90e635b477c7a9bd5e6e_118x90.jpg" width="118" height="90" alt=""> 
                    </a>
              
                    <a style='padding:10px 10px 10px 10px'>
                        <img src="http://ochanin.com/data/file/realHouse/thumb-1147502322_0o7dEarb_5bbcbad588f7c6560bba390aaad9bf8abf474223_118x90.jpg" width="118" height="90" alt=""> 
                    </a> 
            
                    <a style='padding:10px 10px 10px 10px'>
                        <img src="http://ochanin.com/data/file/realHouse/thumb-1147502322_UhxvSYBo_a97da00d99c3f9e648d3762d97d3e3949cffa98c_118x90.jpg" width="118" height="90" alt=""> 
                    </a>  
            
                    <a style='padding:10px 10px 10px 10px'>
                         
                    </a>  
                </div> 
                <br>
                <div id='target'>
                    <a style='padding:10px 10px 10px 10px'>
                        <img src="http://ochanin.com/data/file/realHouse/thumb-1147502322_zwMoElvx_e9b080e6b4c56d5d7dee90e635b477c7a9bd5e6e_118x90.jpg" width="118" height="90" alt=""> 
                    </a>
              
                    <a style='padding:10px 10px 10px 10px'>
                        <img src="http://ochanin.com/data/file/realHouse/thumb-1147502322_0o7dEarb_5bbcbad588f7c6560bba390aaad9bf8abf474223_118x90.jpg" width="118" height="90" alt=""> 
                    </a>
           
                    <a style='padding:10px 10px 10px 10px'>
                        <img src="http://ochanin.com/data/file/realHouse/thumb-1147502322_1oXBz2ms_4ee9cecd4a860a0e3fe56308c6dfde44137440ee_118x90.jpg" width="118" height="90" alt=""> 
                    </a> 
            
                    <a style='padding:10px 10px 10px 10px'>
                         
                    </a> 
                </div> 
            </div> 
        </div> 
    </div>
    </div>   

                    <?php
                        // 파일 출력
                        $v_img_count = count($view['file']);
                        if($v_img_count) {
                            echo "<div id=\"bo_v_img\">\n";

                            for ($i=0; $i<=count($view['file']); $i++) {
                                if ($view['file'][$i]['view']) {
                                    //echo $view['file'][$i]['view'];
                                    echo get_view_thumbnail($view['file'][$i]['view']);
                                }
                            }

                            echo "</div>\n";
                        }
                     ?> 

                </div>
                <div class="col-sm-6">
                    <?php echo get_view_thumbnail($view['content']); ?>
                </div>
            </div>
        </div>



        <br><br><br>

    <style>
        .leftmenu {
            color: #0997ED;
            font-weight: bold;
            font-size: 16px;
            text-align: center;
            vertical-align: top;
        }

        table {
            width: 100%;
            border: 1px solid black;
        }

        th {
            height: 20px;
        }

        td {
            height: 50px;
            vertical-align: bottom;
        }
        th, td {
            padding: 15px;
            text-align: left;
            border: 1px solid black;
        }        
    </style>

        <!-- 본문 내용 시작 { -->
        <div id="bo_v_con"> 
            <table>
                <tr>
                    <th class='leftmenu' width="100px">
                        일정
                    </th>
                    <th class='leftmenu'>
                        내용
                    </th>
                </tr>
            <?php

              $username="root";
              $password="";
              $database="memoa";

              // Opens a connection to a MySQL server

              $connection=mysql_connect ('localhost', $username, $password);
              if (!$connection) {  die('Not connected : ' . mysql_error());}

              // Set the active MySQL database

              $db_selected = mysql_select_db($database, $connection);
              mysql_query(" set names utf8 ");
              if (!$db_selected) {
                die ('Can\'t use db : ' . mysql_error());
              } 

              $topic = $_GET['wr_id'];      

              // Select all the rows in the markers table
              // A && 1 day

              $query = "SELECT * FROM g5_write_boardone WHERE wr_id=$topic  ";
              $result = mysql_query($query);
              if (!$result) {
                die('Invalid query: ' . mysql_error());
              } 

              while ($row = @mysql_fetch_assoc($result)){
                $topic = $row['wr_num'];
                // Add to XML document node
              }

              // Select all the rows in the markers table
              // A && 1 day

              $query = "SELECT * FROM g5_write_boardone WHERE wr_num='$topic' && wr_reply='A'  ";
              $result = mysql_query($query);
              if (!$result) {
                die('Invalid query: ' . mysql_error());
              } 

              while ($row = @mysql_fetch_assoc($result)){
                echo '<tr><td class="leftmenu" rowspan="2">'; 
                    echo '<br> 1 Day <br><br>';
                    echo preg_replace('/,/', '<br />', $row['wr_link1']);
                echo '</td><td>';
                    echo $row['wr_content'];
                echo '</td></tr>'; 
                echo '<td>';
                    echo '식사: '.$row['wr_link2'].'<br>';
                echo '</td></tr>';  
                // Add to XML document node
              }

               
              // B && 2 day

              $query = "SELECT * FROM g5_write_boardone WHERE wr_num='$topic' && wr_reply='B'  ";
              $result = mysql_query($query);
              if (!$result) {
                die('Invalid query: ' . mysql_error());
              } 

              while ($row = @mysql_fetch_assoc($result)){
                echo '<tr><td class="leftmenu">';
                    echo $row['wr_reply'].'<br>';
                    echo '2 Day <br>';
                    echo preg_replace('/,/', '<br />', $row['wr_link1']);
                echo '</td><td>';
                    echo $row['wr_content'];
                    echo '식사: '.$row['wr_link2'].'<br>';                  
                echo '</td></tr>';  
                // Add to XML document node
              }

               
              // C && 3 day

              $query = "SELECT * FROM g5_write_boardone WHERE wr_num='$topic' && wr_reply='C'  ";
              $result = mysql_query($query);
              if (!$result) {
                die('Invalid query: ' . mysql_error());
              } 

              while ($row = @mysql_fetch_assoc($result)){
                echo '<tr><td class="leftmenu">';
                    echo $row['wr_reply'].'<br>';
                    echo '3 Day <br>';
                    echo preg_replace('/,/', '<br />', $row['wr_link1']);
                echo '</td><td>';
                    echo $row['wr_content'];                  
                echo '</td></tr>';  
                // Add to XML document node
              }

               
              // D && 4 day

              $query = "SELECT * FROM g5_write_boardone WHERE wr_num='$topic' && wr_reply='D'  ";
              $result = mysql_query($query);
              if (!$result) {
                die('Invalid query: ' . mysql_error());
              } 

              while ($row = @mysql_fetch_assoc($result)){
                echo '<tr><td class="leftmenu">';
                    echo $row['wr_reply'].'<br>';
                    echo '4 Day <br>';
                    echo preg_replace('/,/', '<br />', $row['wr_link1']);
                echo '</td><td>';
                    echo $row['wr_content'];
                    echo $row['wr_link2'].'<br>';
                echo '</td></tr>';  
                // Add to XML document node
              }  
             
            ?> 
            </table>
        </div>
        <!-- } 본문 내용 끝 --> 
    </section>

    <?php
        include_once(G5_SNS_PATH."/view.sns.skin.php");
    ?> 

    <!-- 링크 버튼 시작 { -->
    <div id="bo_v_bot">
        <?php echo $link_buttons ?>
    </div>
    <!-- } 링크 버튼 끝 -->

</article>
<!-- } 게시판 읽기 끝 -->

<script>
<?php if ($board['bo_download_point'] < 0) { ?>
$(function() {
    $("a.view_file_download").click(function() {
        if(!g5_is_member) {
            alert("다운로드 권한이 없습니다.\n회원이시라면 로그인 후 이용해 보십시오.");
            return false;
        }

        var msg = "파일을 다운로드 하시면 포인트가 차감(<?php echo number_format($board['bo_download_point']) ?>점)됩니다.\n\n포인트는 게시물당 한번만 차감되며 다음에 다시 다운로드 하셔도 중복하여 차감하지 않습니다.\n\n그래도 다운로드 하시겠습니까?";

        if(confirm(msg)) {
            var href = $(this).attr("href")+"&js=on";
            $(this).attr("href", href);

            return true;
        } else {
            return false;
        }
    });
});
<?php } ?>

function board_move(href)
{
    window.open(href, "boardmove", "left=50, top=50, width=500, height=550, scrollbars=1");
}
</script>

<script>
$(function() {
    $("a.view_image").click(function() {
        window.open(this.href, "large_image", "location=yes,links=no,toolbar=no,top=10,left=10,width=10,height=10,resizable=yes,scrollbars=no,status=no");
        return false;
    });

    // 추천, 비추천
    $("#good_button, #nogood_button").click(function() {
        var $tx;
        if(this.id == "good_button")
            $tx = $("#bo_v_act_good");
        else
            $tx = $("#bo_v_act_nogood");

        excute_good(this.href, $(this), $tx);
        return false;
    });

    // 이미지 리사이즈
    $("#bo_v_atc").viewimageresize();
});

function excute_good(href, $el, $tx)
{
    $.post(
        href,
        { js: "on" },
        function(data) {
            if(data.error) {
                alert(data.error);
                return false;
            }

            if(data.count) {
                $el.find("strong").text(number_format(String(data.count)));
                if($tx.attr("id").search("nogood") > -1) {
                    $tx.text("이 글을 비추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                } else {
                    $tx.text("이 글을 추천하셨습니다.");
                    $tx.fadeIn(200).delay(2500).fadeOut(200);
                }
            }
        }, "json"
    );
}
</script>
<!-- } 게시글 읽기 끝 -->