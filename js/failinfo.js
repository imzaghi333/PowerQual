/**
 *              ,----------------,              ,---------,
 *         ,-----------------------,          ,"        ,"|
 *       ,"                      ,"|        ,"        ,"  |
 *      +-----------------------+  |      ,"        ,"    |
 *      |  .-----------------.  |  |     +---------+      |
 *      |  |                 |  |  |     | -==----'|      |
 *      |  |  I LOVE OS X    |  |  |     |         |      |
 *      |  |  Bad command or |  |  |/----|`---=    |      |
 *      |  |  ~$ python3     |  |  |   ,/|==== ooo |      ;
 *      |  |                 |  |  |  // |(((( [33]|    ,"
 *      |  `-----------------'  |," .;'| |((((     |  ,"
 *      +-----------------------+  ;;  | |         |,"
 *         /_)______________(_/  //'   | +---------+
 *    ___________________________/___  `,
 *   /  oooooooooooooooo  .o.  oooo /,   \,"-----------
 *  / ==ooooooooooooooo==.o.  ooo= //   ,`\--{)B     ,"
 * /_==__==========__==_ooo__ooo=_/'   /___________,"
 *
*/

var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.1.1.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var script2 = document.createElement("script"); 
script2.type = "text/javascript"; 
script2.src = "js/layui/layui.js"; 
document.getElementsByTagName("head")[0].appendChild(script2);

function addLoadEvent(func){
    var oldonload = window.onload;
    if(typeof window.onload != "function"){
        window.onload = func;
    }
    else{
        window.onload = function(){
            oldonload();
            func();
        }
    }
}

/**
 * info裏可以給unit添加Hot,cold, room
 */
function setTemperature(cell){
    var sel_id = "temp"+cell;
    var temp_id = "subject9["+(cell-1)+"]";
    var order_id = "test_order["+(cell-1)+"]";

    //alert("選擇框ID: "+sel_id+", 溫度文本框ID: "+temp_id+" ,test order ID: "+order_id);
    var selbox = document.getElementById(sel_id);
    var selbox_val = selbox.value
    window.opener.document.getElementById(temp_id).value=selbox_val;
    switch (selbox_val) {
        case "Hot":
            window.opener.document.getElementById(order_id).style.color="#cc2229";
            window.opener.document.getElementById(temp_id).value="Hot";
            break;
        case "Cold":
            window.opener.document.getElementById(order_id).style.color="#1565c0";
            window.opener.document.getElementById(temp_id).value="Cold";
            break
        case "Room":
            window.opener.document.getElementById(order_id).style.color="#0aa344";
            window.opener.document.getElementById(temp_id).value="Room";
            break
    
        default:
            break;
    }
}

/**
 * 设置单个测试机pass or TBD;这样你就不用为某一个测试机进入fail里单独为它填Pass了
*/
function setPassOrTBD(cell){
    var sel_id = "pt"+cell;    //fail.php pass or TDB select
    var result_id = "subject18["+(cell-1)+"]";

    var selbox = document.getElementById(sel_id);
    var selbox_val = selbox.value
    switch (selbox_val) {
        case "Pass":
            window.opener.document.getElementById(result_id).value="Pass";
            break;
        case "TBD":
            window.opener.document.getElementById(result_id).value="TBD";
            break;
        case "Fail":
            window.opener.document.getElementById(result_id).value="Fail";
            break;
        case "EC Fail":
            window.opener.document.getElementById(result_id).value="EC Fail";
            break;
        case "Known Fail (Open)":
            window.opener.document.getElementById(result_id).value="Known Fail (Open)";
            break;
        case "Known Fail (Close)":
            window.opener.document.getElementById(result_id).value="Known Fail (Close)";
            break;
        default:
            break;
    }
}

/**
 * set result
*/
function returnResult(cell){
    var result_id = "subject18["+(cell-1)+"]";
    var sel_id = "fail_result"+cell;

    var selbox = document.getElementById(sel_id);
    var selbox_val = selbox.value;
    switch (selbox_val) {
        case "Pass":
            window.opener.document.getElementById(result_id).value="Pass";
            break;
        case "TBD":
            window.opener.document.getElementById(result_id).value="TBD";
            break;
        case "Fail":
            window.opener.document.getElementById(result_id).value="Fail";
            break;
        case "EC Fail":
            window.opener.document.getElementById(result_id).value="EC Fail";
            break;
        case "Known Fail (Open)":
            window.opener.document.getElementById(result_id).value="Known Fail (Open)";
            break;
        case "Known Fail (Close)":
            window.opener.document.getElementById(result_id).value="Known Fail (Close)";
            break;
        default:
            break;
    }
}

/*
// 1.Defect Mode(Symptom)
function returnvalue1(selectid,val){
    window.opener.document.getElementById("subject1["+selectid+"]").value=val;
}
// 2.Defect Mode(Symptom+Finding)
function returnvalue2(selectid,val){
    window.opener.document.getElementById("subject2["+selectid+"]").value=val;
}
// 3.RCCA
function returnvalue3(selectid,val){
    window.opener.document.getElementById("subject3["+selectid+"]").value=val;
}
// 4.Issuestatus
function returnvalue4(selectid,val){
    window.opener.document.getElementById("subject4["+selectid+"]").value=val;
}
// 5.Category
function returnvalue5(selectid,val){
    window.opener.document.getElementById("subject5["+selectid+"]").value=val;
}
// 6.PIC
function returnvalue6(selectid,val){
    window.opener.document.getElementById("subject6["+selectid+"]").value=val;
}
// 7.JIRA
function returnvalue7(selectid,val){
    window.opener.document.getElementById("subject7["+selectid+"]").value=val;
}
// 8.SPR
function returnvalue8(selectid,val){
    window.opener.document.getElementById("subject8["+selectid+"]").value=val;
}
*/

// 9.TEMP
function returnvalue9(selectid,val){
    if(val.length!=0){
        window.opener.document.getElementById("subject9["+selectid+"]").value=val;
    }
}
/*
// 10.Dropcycles
function returnvalue10(selectid,val){
    window.opener.document.getElementById("subject10["+selectid+"]").value=val;
}
// 11.Drops
function returnvalue11(selectid,val){
    window.opener.document.getElementById("subject11["+selectid+"]").value=val;
}
// 12.Dropside
function returnvalue12(selectid,val){
    window.opener.document.getElementById("subject12["+selectid+"]").value=val;
}
// 13.HIT
function returnvalue13(selectid,val){
    window.opener.document.getElementById("subject13["+selectid+"]").value=val;
}
// 14.NextCheckpointDate
function returnvalue14(selectid,val){
    window.opener.document.getElementById("subject14["+selectid+"]").value=val;
}
// 15.IssuePublished
function returnvalue15(selectid,val){
    window.opener.document.getElementById("subject15["+selectid+"]").value=val;
}
// 16.ORTMFGDate
function returnvalue16(selectid,val){
    window.opener.document.getElementById("subject16["+selectid+"]").value=val;
}
// 17.ReportedDate
function returnvalue17(selectid,val){
    window.opener.document.getElementById("subject17["+selectid+"]").value=val;
}
// 18.change default result
function returnvalue18(selectid,val){
    if(val.length!=0){
        window.opener.document.getElementById("subject18["+selectid+"]").value=val;
    }
}
*/

// 19.Fail symptom
function returnvalue19(row_no,val){
    //alert("Row:"+row_no+" ,value:"+val);
    if(val.length!=0){
        var row = row_no-1;
        window.opener.document.getElementById("fail["+row+"]").value+=val+"\n";
    }
}
// 20.RCCA
function returnvalue20(row_no,val){
    //alert("Row:"+row_no+" ,value:"+val);
    if(val.length!=0){
        var row = row_no-1;
        window.opener.document.getElementById("rcca["+row+"]").value+=val+"\n";
    }
}

/**
 * added on 2022-05-05 for deleting a failure record
 * 刪除一個failure記錄,數據保留在數據庫,但不知頁面上顯示,PHP文件裏設置Unitsno=NULL即可
 */
function delOneFailure(rowid,cellid,count,currentid,rows){
    //alert(rowid+" "+cellid+" "+count+" "+currentid+" "+rows);
    //http://localhost/DQA/fail.php?rowid=1&cellid=10&count=5&currentid=98&rows=4
    if(window.confirm("您確定刪除嗎？")){
        var del_select = document.getElementById("del_fail");
        var del_val = del_select.value;
        window.location.href="./comm/delete.php?failure_id="+del_val+"&rowid="+rowid+"&cellid="+cellid+"&count="+count+"&currentid="+currentid+"&rows="+rows;
    }
}

/**
 * press button for a row tests set to pass
 * @param {*} rowid button所在的行号
 * @param {*} number 测试机数量
*/
function oneRowAllPass(rowid,number){
    var row_no = rowid-1;          //行號,從0開始計數
    var cell_length = number+4;  //單元格數量,从0开始计数

    var reg1 = RegExp(/value=""/i);  //匹配tes order為空的單元格,不改變默認的TBD
    var reg2 = RegExp(/TBD/i);       //匹配有tes order單元格,改變其結果為Pass
    
    //父窗口edit_matrix.php处于开启状态才可以设置一键全pass
    if(window.opener && !window.opener.closed){
        var oTab = window.opener.document.getElementById("customers");
        var oTbody = oTab.tBodies[0];    //表格不含標題欄部分
        for(var i=4; i<cell_length; i++){
            var s = oTbody.rows[row_no].cells[i].innerHTML;    //獲取原來單元格的html内容
            var m = "";
            if(!s.match(reg1)){
                m = s.replace(reg2,"Pass");    //有test order字符串的TBD改成Pass
                oTbody.rows[row_no].cells[i].innerHTML = m;    //新的html替換原來的html内容
            }
        }
        oTbody.rows[row_no].cells[cell_length+2].innerHTML = "<input style='width:70px;' name='status' id='status' type='text' value='Complete' readonly />";
        oTbody.rows[row_no].cells[cell_length+3].innerHTML = "<input style='width:110px;' name='result' id='result' type='text' value='Pass' readonly />";
        layer.msg("第"+rowid+"行全部設置為Pass U•ェ•*U",{icon: 6});
    }
    else{
        layer.msg("你关闭了Edit Matrix页面",{icon:5});
    }
}