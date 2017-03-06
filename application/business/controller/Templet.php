<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\business\controller;
use app\common\controller\Base;
/**
 * Description of templet
 *
 * @author Sammy Guergachi <sguergachi at gmail.com>
 */
class Templet extends Base{
    
    /**
     * 付款超时
     * @return type
     */
    public function show_time_out() {
        return view(ROOT_PATH . 'templates/timeout.html');
    }
    
    /**
     * 收款超时
     * @return type
     */
    public function show_trade() {
         return view(ROOT_PATH . 'templates/trade.html');
    }
    
    /**
     * 
     */
    public function show_search1() {
    	 
    	 $year  = date("Y",time());
    	 $byear = $year-1;
    	 $year_arr = array($year,$byear);
         return view(ROOT_PATH . 'templates/search1.html',['year_arr'=>$year_arr]);
    }
    
    public function show_search() {
    	$year  = date("Y",time());
    	$byear = $year-1;
    	$year_arr = array($year,$byear);
    	return view(ROOT_PATH . 'templates/search.html',['year_arr'=>$year_arr]);
        // return view(ROOT_PATH . 'templates/search.html');
    }
    
    public function show_match() {
         return view(ROOT_PATH . 'templates/match.html');
    }
    
    public function show_manual() {
         return view(ROOT_PATH . 'templates/manual.html');
    }
    
    public function show_match_list() {
        return view(ROOT_PATH . 'templates/list.html');
    }
    
    public function  show_tranfer_order(){
    	return view(ROOT_PATH . 'templates/transfer.html');
    }
}
