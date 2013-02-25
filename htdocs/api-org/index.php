<?php

	//设置为UTF格式的返回
	header("Content-Type:text/html;charset=utf-8");

	if($_GET['method']=='read'){
		
		//首页一卡通信息
		//api/?method=read&target=card&page=-1
		if($_GET['target']=='card'&&$_GET['page']==-1){
			$arr = array ();
			for ($i=0; $i < 8; $i++) { 
				$arr[$i] = array ('id'=>'1'.$i,'card_id'=>'20092*'.$i.'473','place'=>'学子食堂','date'=>'2013-01-0'.$i);
			}
		}
		
		//分类页中的列表信息
		//api/?method=read&target=claim&page=1
		if($_GET['target']=='claim' || $_GET['target']=='find' && $_GET['page']>0){
			$arr = array ();
			for ($i=0; $i < 11; $i++) {
				$arr[$i] = array ('id'=>'2'.$i,'name'=>'白色金立手机带黑保护套','place'=>'行政楼副楼二楼','date'=>'2013-01-0'.$i,
				'state'=>'process',
				'info'=>'白色触屏智能手机，型号为金立GN106，八成新，外有黑色保护套，里面没有插SIM卡，壁纸为蓝天下的鹅，存有100多个联系人，大量的课件，对我很重要，希望拾到者与我联系，本人将不胜感激!');
			}
		}		

			//首页招领信息 & 首页失物信息
    		//api/?method=read&target=claim&page=-1
    		if($_GET['target']=='claim' || $_GET['target']=='find' && $_GET['page']==-1){
    			$arr = array ();
    			for ($i=0; $i < 5; $i++) {
    				$arr[$i] = array ('id'=>'2'.$i,'name'=>'白色金立手机带黑保护套','place'=>'行政楼副楼二楼','date'=>'2013-01-0'.$i,
    				'state'=>'process',
    				'info'=>'白色触屏智能手机，型号为金立GN106，八成新，外有黑色保护套，里面没有插SIM卡，壁纸为蓝天下的鹅，存有100多个联系人，大量的课件，对我很重要，希望拾到者与我联系，本人将不胜感激!');
    			}
    		}

	}
	
	var_dump($arr);
	//echo json_encode($arr);
	