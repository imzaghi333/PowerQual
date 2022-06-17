/* ********************************************
             __   _,--="=--,_   __
            /  \."    .-.    "./  \
           /  ,/  _   : :   _  \/` \
           \  `| /o\  :_:  /o\ |\__/
            `-'| :="~` _ `~"=: |
               \`     (_)     `/
        .-"-.   \      |      /   .-"-.
.------{     }--|  /,.-'-.,\  |--{     }-----.
 )     (_)_)_)  \_/`~-===-~`\_/  (_(_(_)    (
(  Are you going to buy a BMW or an Audi TT  )
 )                                          (
'--------------------------------------------'
*/

var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.6.0.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var script2 = document.createElement("script"); 
script2.type = "text/javascript"; 
script2.src = "js/layui/layui.js"; 
document.getElementsByTagName("head")[0].appendChild(script2);

/**
* 替代window.onload方法  cell,row_no,iid,unit_id,numbers,select_id,currentid,row
*/
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

function savegoback(id,row_id,selectid,number,currentid,rows,temp){
    //alert(row_id);
    //alert(window.parent.location);
    //window.location.replace("http://dqa.myftp.org:8080/fail.php?rowid="+row_id+"&cellid="+selectid+"&count="+number+"&currentid="+currentid+"&rows="+rows+"&id="+id+"&temp="+temp);
    window.location.replace("http://localhost/DQA/fail.php?rowid="+row_id+"&cellid="+selectid+"&count="+number+"&currentid="+currentid+"&rows="+rows+"&id="+id+"&temp="+temp);
}

function goback(cell,row_id,selectid,number,currentid,rows,reload){
    //alert(reload);
    // alert(window.parent.document.getElementById("3"));
    var sel_id = "temp"+cell;
    var temp_id = "subject9["+(cell-1)+"]";
    var order_id = "test_order["+(cell-1)+"]";
   
    //alert("選擇框ID: "+sel_id+", 溫度文本框ID: "+temp_id+" ,test order ID: "+order_id);
    var selbox = document.getElementById(sel_id);
    var selbox_val = selbox.value
    //alert(selbox_val);

    window.opener.document.getElementById(temp_id).value=selbox_val;
    //alert(selbox_val);
    switch (selbox_val) {
        case "Hot":
            window.opener.document.getElementById(order_id).style.color="#000000";
            window.opener.document.getElementById(temp_id).value="Hot";
            break;
        case "Cold":
            window.opener.document.getElementById(order_id).style.color="#000000";
            window.opener.document.getElementById(temp_id).value="Cold";
            break
        case "Room":
            window.opener.document.getElementById(order_id).style.color="#000000";
            window.opener.document.getElementById(temp_id).value="Room";
            break
    
        default:
            break;
    }
    window.location.replace(document.referrer);
}


/**
 * info.php可以給unit添加Hot,cold, room 而且Testorder颜色会根据温度显示不同颜色
*/
function setTemperature(cell,row_no,iid,unit_id,numbers,select_id,currentid,rows,rownums,tmpid){
    var sel_id = "temp"+cell;
    var temp_id = "subject9["+(cell-1)+"]";
    var order_id = "test_order["+(cell-1)+"]";
    var selbox = document.getElementById(sel_id);
    var selbox_val = selbox.value
    //document.getElementById('temp_frm').submit();
    //alert("submit");
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
    document.getElementById(unit_id).href="fail.php?cell="+cell+"&id="+iid+"&rowid="+row_no+"&unit=Unit"+unit_id+"&temp="+selbox_val+"&cellidII="+select_id+"&counts="+numbers+"&currentid="+currentid+"&rows="+rows+"&reload=2";
    if(rownums!=0){
        //window.location = "http://dqa.myftp.org:8080/fail.php?rowid="+row_no+"&cell="+cell+"&cellid="+select_id+"&count="+numbers+"&currentid="+currentid+"&rows="+rows+"&updatetemp=" + selbox_val+"&RecordId="+tmpid;
        window.location = "http://localhost/DQA/fail.php?rowid="+row_no+"&cell="+cell+"&cellid="+select_id+"&count="+numbers+"&currentid="+currentid+"&rows="+rows+"&updatetemp=" + selbox_val+"&RecordId="+tmpid;
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
 * Set Result
*/
function returnResult(row,cell,unit){
    var result_id = "subject18["+(cell-1)+"]";
    var sel_id = "fail_result"+cell;
    var fail_sysm = "fail["+(row-1)+"]";

    var selbox = document.getElementById(sel_id);
    var selbox_val = selbox.value;
    switch (selbox_val) {
        case "Pass":
            window.opener.document.getElementById(result_id).value="Pass";
            window.opener.document.getElementById(fail_sysm).value += "Unit"+unit+": ";
            break;
        case "TBD":
            window.opener.document.getElementById(result_id).value="TBD";
            window.opener.document.getElementById(fail_sysm).value += "Unit"+unit+": ";
            break;
        case "Fail":
            window.opener.document.getElementById(result_id).value="Fail";
            window.opener.document.getElementById(fail_sysm).value += "Unit"+unit+": ";
            break;
        case "EC Fail":
            window.opener.document.getElementById(result_id).value="EC Fail";
            window.opener.document.getElementById(fail_sysm).value += "Unit"+unit+": ";
            break;
        case "Known Fail (Open)":
            window.opener.document.getElementById(result_id).value="Known Fail (Open)";
            window.opener.document.getElementById(fail_sysm).value += "Unit"+unit+": ";
            break;
        case "Known Fail (Close)":
            window.opener.document.getElementById(result_id).value="Known Fail (Close)";
            window.opener.document.getElementById(fail_sysm).value += "Unit"+unit+": ";
            break;
        default:
            break;
    }
}

/**
 * matrix edit页面需要填到Fail Symptom, RCCA 的内容. 5/24我重新编写了这一段的Javascript代码
 * 1.Defect Mode Defect Mode(Symptom)
*/
function returnFailSympton(row,cell){
    var sel_id = "df1_"+cell;
    var selbox = document.getElementById(sel_id);
    var fail_sysm = "fail["+(row-1)+"]";
    var selbox_val = selbox.value;

    if(selbox_val){
        window.opener.document.getElementById(fail_sysm).value += selbox_val+"; ";
    }
}

/** 2.TEMP-cold,hot,room */
function returnTEMP(row,cell){
    var sel_id = "temp"+cell;
    var selbox = document.getElementById(sel_id);
    var fail_sysm = "fail["+(row-1)+"]";
    var selbox_val = selbox.value;

    switch (selbox_val) {
        case "Hot":
            window.opener.document.getElementById(fail_sysm).value += selbox_val+"; ";
            break;
        case "Cold":
            window.opener.document.getElementById(fail_sysm).value += selbox_val+"; ";
            break
        case "Room":
            window.opener.document.getElementById(fail_sysm).value += selbox_val+"; ";
        default:
            break;
    }
}

/** 3.Drop Cycle */
function returnDropCycle(row,cell){
    var drop_cycle_id = "drop_cycle"+cell;
    var drop_cycle = document.getElementById(drop_cycle_id);
    var fail_sysm = "fail["+(row-1)+"]";
    if(drop_cycle.value){
        window.opener.document.getElementById(fail_sysm).value += drop_cycle.value+" cycles; ";
    }
}

/** 4.Drops */
function retrunDrops(row,cell){
    var drops = document.getElementById("drops"+cell);
    var fail_sysm = "fail["+(row-1)+"]";
    if(drops.value){
        window.opener.document.getElementById(fail_sysm).value += drops.value+" drops; ";
    }
}

/** 5. Drop side */
function returnDropSide(row,cell){
    var drop_side = document.getElementById("drop_side"+cell);
    var fail_sysm = "fail["+(row-1)+"]";
    if(drop_side.value){
        window.opener.document.getElementById(fail_sysm).value += drop_side.value+" side; ";
    }
}

/** 6. Hit Tumble */
function returnHitTumble(row,cell){
    var fail_sysm = "fail["+(row-1)+"]";
    var hit_tumble = document.getElementById("hit"+cell);
    if(hit_tumble.value){
        window.opener.document.getElementById(fail_sysm).value += hit_tumble.value+" hits; ";
    }
}

/**
 * @param {*} row 行号; fail.php从1开始; matrix_edit.php作为行编号从0开始
 * @param {*} cell 单元格编号,从1开始; matrix_edit.php用作id编号从0开始
 * @param {*} unit 测试机编号
 * RCCA 
*/
function returnRCCA(row,cell,unit){
    var rcca_area = "rcca["+(row-1)+"]";
    var fail_rcca = document.getElementById("rcca"+cell);
    if(fail_rcca.value){
        window.opener.document.getElementById(rcca_area).value += "Unit"+unit+": "+fail_rcca.value+"; ";
    }
}


/**
 * 刪除一個failure記錄
 */
function delOneFailure(rowid,cellid,count,currentid,rows,temp){
    if(temp=="1")
    {
        temp="Hot";
    }
    if(temp=="2")
    {
        temp="Cold";
    }
    if(temp=="3")
    {
        temp="Room";
    }
    if(window.confirm("您確定刪除嗎？刪除不可恢復")){
        var del_select = document.getElementById("del_fail");
        var del_val = del_select.value;
        window.location.href="./comm/delete.php?failure_id="+del_val+"&rowid="+rowid+"&cellid="+cellid+"&count="+count+"&currentid="+currentid+"&rows="+rows+"&temp="+temp;
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