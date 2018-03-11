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
    .col-lg-6 {
    	font-family: 'KBIZ Hanmaeum Gothic', sans-serif;
    }    
    .col-lg-6 h1 {
		font-family: 'Yanolja Ya', cursive;
    }    
</style>

	<script src="<?php echo $board_skin_url; ?>/script.js"></script>
	<link rel="stylesheet" href="<?php echo $board_skin_url; ?>/style.css">

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

	for($i=0; $i < 20; $i++){
    	get_thumbnail($bo_table, $view['file'][$i]['file'], 590, 380, $view['file'][$i]['bf_content'], 1);  
	}; 
?>


<!-- 쇼핑몰 정보 시작 --> 

<div class="container">
	<div class="row">
		<div class="col-md-6"> 
			<div class="mara_view_wrap" style="width:<?php echo $width; ?>;"> 
			    <div align='center'>
			        <div class="photo">
			            <?php if($view['file']['0']['file']){ ?>
			            	<?php echo get_thumbnail($bo_table, $view['file'][0]['file'], 530, 340, $view['file'][0]['bf_content'], 1); ?>
			            <?php } ?>  
			            <br><br>
			        </div>
			         <div style='background-color: #E7E7E7; padding: 10px;'>
			             <div id='target'>
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][0]['file'], 87, 62, $view['file'] [0]['bf_content'], 1); ?> 
			                </a>
			          
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][1]['file'], 87, 62, $view['file'] [1]['bf_content'], 1); ?> 
			                </a>
			       
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][2]['file'], 87, 62, $view['file'] [2]['bf_content'], 1); ?> 
			                </a>
			        
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][3]['file'], 87, 62, $view['file'] [3]['bf_content'], 1); ?> 
			                </a>  
			        
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][4]['file'], 87, 62, $view['file'] [4]['bf_content'], 1); ?> 
			                </a>  
			            </div>  
			            <div id='target'>
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][5]['file'], 87, 62, $view['file'] [5]['bf_content'], 1); ?> 
			                </a>
			          
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][6]['file'], 87, 62, $view['file'] [6]['bf_content'], 1); ?> 
			                </a>
			       
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][7]['file'], 87, 62, $view['file'] [7]['bf_content'], 1); ?> 
			                </a>
			        
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][8]['file'], 87, 62, $view['file'] [8]['bf_content'], 1); ?> 
			                </a>  
			        
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][9]['file'], 87, 62, $view['file'][9]['bf_content'], 1); ?> 
			                </a>  
			            </div> 
			            <div id='target'>
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][10]['file'], 87, 62, $view['file'][5]['bf_content'], 1); ?> 
			                </a>
			          
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][11]['file'], 87, 62, $view['file'][6]['bf_content'], 1); ?> 
			                </a>
			       
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][12]['file'], 87, 62, $view['file'][7]['bf_content'], 1); ?> 
			                </a>
			        
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][13]['file'], 87, 62, $view['file'][8]['bf_content'], 1); ?> 
			                </a>  
			        
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][14]['file'], 87, 62, $view['file'] [9]['bf_content'], 1); ?> 
			                </a>   
			            </div> 
			            <div id='target'>
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][15]['file'], 87, 62, $view['file'][5]['bf_content'], 1); ?> 
			                </a>
			          
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][16]['file'], 87, 62, $view['file'][6]['bf_content'], 1); ?> 
			                </a>
			       
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][17]['file'], 87, 62, $view['file'][7]['bf_content'], 1); ?> 
			                </a>
			        
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][18]['file'], 87, 62, $view['file'][8]['bf_content'], 1); ?> 
			                </a>  
			        
			                <a>
			                    <?php echo get_thumbnail($bo_table, $view['file'][19]['file'], 87, 62, $view['file'] [9]['bf_content'], 1); ?> 
			                </a>   
			            </div> 
			        </div> 
			    </div> 
			</div> 
		</div> 
		<div class="col-md-6" style="text-align: left;"> 
			<?php echo get_view_thumbnail($view['content']); ?>
		</div>
	</div>
</div>

<br><br><br><br><br>


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
        <div id="bo_v_con" style="width: 1200px;"> 
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
              $database="memot";

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

              $query = "SELECT * FROM g5_write_tour WHERE wr_id=$topic  ";
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

              $query = "SELECT * FROM g5_write_tour WHERE wr_num='$topic' && wr_reply='A'  ";
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

              $query = "SELECT * FROM g5_write_tour WHERE wr_num='$topic' && wr_reply='B'  ";
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

              $query = "SELECT * FROM g5_write_tour WHERE wr_num='$topic' && wr_reply='C'  ";
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

              $query = "SELECT * FROM g5_write_tour WHERE wr_num='$topic' && wr_reply='D'  ";
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

<br><br><br><br>