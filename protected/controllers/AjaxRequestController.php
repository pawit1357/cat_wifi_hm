<?php

class AjaxRequestController extends CController
{

    public $layout = 'ajax';

    private $_model;

    /**
     * Index action is the default action in a controller.
     */
    public function actionIndex()
    {}

    public function actionMovieContent($mac, $phone)
    {
        mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
        mysql_select_db(ConfigUtil::getDbName());
        
        $json = array();
        $sql = "SELECT id,name,vedio_time,file_path FROM tb_ad_plan ORDER BY RAND() LIMIT 0,1";
        $plan_id = 1;
        if ($result = mysql_query($sql)) {
            while ($item = mysql_fetch_assoc($result)) {
                $json = $item;
                $plan_id = $item["id"];
            }
            
            $query = "INSERT INTO tb_ad_logs (plan_id,play_from_mac,hotspot_name,create_date) VALUES(" . $plan_id . ",'" . $mac . "','" . $phone . "',NOW())";
            
            mysql_query($query);
            mysql_close();
        } else {
            print mysql_error();
        }
        echo json_encode($json);
        
    }
    public function actionCheckRegister($mac)
    {        
        mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
        mysql_select_db(ConfigUtil::getDbName());
        
        $json = array();
        $sql = "SELECT id FROM tb_register where mac_addr='".$mac."'";
        if ($result = mysql_query($sql)) {
            while ($item = mysql_fetch_assoc($result)) {
                $json = $item;
            }
            mysql_close();
        } else {
            print mysql_error();
        }
        echo json_encode($json);
        
    }
    public function actionRegister($mac, $cid, $phone)
    {
        mysql_connect(ConfigUtil::getHostName(), ConfigUtil::getUsername(), ConfigUtil::getPassword());
        mysql_select_db(ConfigUtil::getDbName());
        
        $json = array();
        
        $query = "INSERT INTO tb_register (mac_addr,phone_num,cid) VALUES('" . $mac . "','" . $phone . "','" . $cid . "')";
        
        mysql_query($query);
        mysql_close();
        
        echo json_encode($json);
    }
}