
## Example
```
php TPLinkCameraControlTest.php admin password url data
php TPLinkCameraControlTest.php admin password http://192.168.2.89:80 '{"method":"do","preset":{"goto_preset": {"id": "1"}}}'
```


## Data Example
```json
// add PTZ preset position 添加預置點
{"method":"do","preset":{"set_preset":{"name":"name","save_ptz":"1"}}}

// PTZ to preset position 轉動到預置點
{"method":"do","preset":{"goto_preset": {"id": "1"}}}

// PTZ by coord 按坐標轉動
{"method":"do","motor":{"move":{"x_coord":"10","y_coord":"0"}}}

// PTZ horizontal by step 水平步進
{"method":"do","motor":{"movestep":{"direction":"0"}}}

// PTZ vertical by step 垂直步進
{"method":"do","motor":{"movestep":{"direction":"90"}}}

// stop PTZ 停止步進
{"method":"do","motor":{"stop":"null"}}

//reset PTZ 雲台重置
{"method":"do","motor":{"manual_cali":"null"}}

// lens mask 鏡頭遮蔽
{"method":"set","lens_mask":{"lens_mask_info":{"enabled":"on"}}}

// manual alarm 手動報警
{"method":"do","msg_alarm":{"manual_msg_alarm":{"action":"start"}}}
{"method":"do","msg_alarm":{"manual_msg_alarm":{"action":"stop"}}}

// toggle green led 綠色led開關
{"method":"set","led":{"config":{"enabled":"off"}}}
{"method":"set","led":{"config":{"enabled":"on"}}}

//auto track moving obj 智能追蹤 攝像機追隨移動物體
{"method":"set","target_track":{"target_track_info":{"enabled":"on"}}}
{"method":"set","target_track":{"target_track_info":{"enabled":"off"}}}

//alarm if found moving obj 檢測到移動物體時報警
{"method":"set","msg_alarm":{"chn1_msg_alarm_info":{"enabled":"on","alarm_type":"0","alarm_mode":["sound"]}}}
{"method":"set","msg_alarm":{"chn1_msg_alarm_info":{"enabled":"on","alarm_type":"0","alarm_mode":["light"]}}}
{"method":"set","msg_alarm":{"chn1_msg_alarm_info":{"enabled":"on","alarm_type":"0","alarm_mode":["sound","light"]}}}
{"method":"set","msg_alarm_plan":{"chn1_msg_alarm_plan":{"enabled":"on","alarm_plan_1":"0000-0000%2c127"}}}

//motion detection 移動偵測 與 偵測靈敏度
{"method":"set","motion_detection":{"motion_det":{"enabled":"off"}}}
{"method":"set","motion_detection":{"motion_det":{"enabled":"on"}}}
{"method":"set","motion_detection":{"motion_det":{"digital_sensitivity":"20"}}}
{"method":"set","motion_detection":{"motion_det":{"digital_sensitivity":"50"}}}
{"method":"set","motion_detection":{"motion_det":{"digital_sensitivity":"80"}}}

//enable record and plan 是否錄制與錄制計劃
{"method":"set","record_plan":{"chn1_channel":{"enabled":"off","monday":"%5b%220000-2400%3a2%22%5d","tuesday":"%5b%220000-2400%3a2%22%5d","wednesday":"%5b%220000-2400%3a2%22%5d","thursday":"%5b%220000-2400%3a2%22%5d","friday":"%5b%220000-2400%3a2%22%5d","saturday":"%5b%220000-2400%3a2%22%5d","sunday":"%5b%220000-2400%3a2%22%5d"}}}
{"method":"set","record_plan":{"chn1_channel":{"enabled":"on","monday":"%5b%220000-2400%3a2%22%5d","tuesday":"%5b%220000-2400%3a2%22%5d","wednesday":"%5b%220000-2400%3a2%22%5d","thursday":"%5b%220000-2400%3a2%22%5d","friday":"%5b%220000-2400%3a2%22%5d","saturday":"%5b%220000-2400%3a2%22%5d","sunday":"%5b%220000-2400%3a2%22%5d"}}}

//reboot and timing reboot 重啟與定時重啟
{"method":"do","system":{"reboot":"null"}}
{"method":"set","timing_reboot":{"reboot":{"enabled":"off","day":"7","time":"03%3a00%3a00"}}}
{"method":"set","timing_reboot":{"reboot":{"enabled":"on","day":"7","time":"03%3a00%3a00"}}}

//greetings 個性語音提示
{"method":"set","greeter":{"chn1_greeter_ctrl":{"enabled":"on"}}}
{"method":"set","greeter":{"chn1_greeter_ctrl":{"enabled":"off"}}}
//greeting volume 音量
{"method":"set","greeter":{"chn1_greeter_audio":{"enter_volume":"77","leave_volume":"77"}}}
//play greetings 播放語音
{"method":"do","greeter":{"test_audio":{"force":"1"}}} 播放默認語音
{"method":"do","greeter":{"test_audio":{"id":"4096","force":"1"}}} 播放指定語音
//id
//0 無
//12288 你好
//4096-4104 依次為 你好歡迎光臨 ..... 
//set enter or leave greetings 設置進入或離開語音
{"method":"set","greeter":{"chn1_greeter_audio":{"enter_audio_id":"0"}}} 無
{"method":"set","greeter":{"chn1_greeter_audio":{"leave_audio_id":"4104"}}}
```

ref: http://blog.xiazhiri.com/Mercury-MIPC251C-4-Reverse.html