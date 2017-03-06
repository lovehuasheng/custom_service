<?php
 $redis = new \redisProxy();
 $redis->connect("127.0.0.1");
 $redis->set("test" .time(),time());

 var_dump($obj->get("test".time()));
 $redis->release();
