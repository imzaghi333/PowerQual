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
* 替代window.onload方法
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
    //alert(window.parent.location);
    window.location.replace("http://dqa.myftp.org:8080/fail.php?rowid="+row_id+"&cellid="+selectid+"&count="+number+"&currentid="+currentid+"&rows="+rows+"&id="+id+"&temp="+temp);
    //window.location.replace("http://localhost/DQA/fail.php?rowid="+row_id+"&cellid="+selectid+"&count="+number+"&currentid="+currentid+"&rows="+rows+"&id="+id+"&temp="+temp);
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
        window.location = "http://dqa.myftp.org:8080/fail.php?rowid="+row_no+"&cell="+cell+"&cellid="+select_id+"&count="+numbers+"&currentid="+currentid+"&rows="+rows+"&updatetemp=" + selbox_val+"&RecordId="+tmpid;
        //window.location = "http://localhost/DQA/fail.php?rowid="+row_no+"&cell="+cell+"&cellid="+select_id+"&count="+numbers+"&currentid="+currentid+"&rows="+rows+"&updatetemp=" + selbox_val+"&RecordId="+tmpid;
    }
}

/**
 * 设置单个测试机pass or TBD;这样你就不用为某一个测试机进入fail里单独为它填Pass了
*/
function setPassOrTBD(cell,row){
    var sel_id = "pt"+cell;    //fail.php pass or TDB select
    var result_id = "subject18["+(cell-1)+"]";
    var status_id = "status"+row;//row从0开始

    var selbox = document.getElementById(sel_id);
    var selbox_val = selbox.value
    switch (selbox_val) {
        case "Pass":
            window.opener.document.getElementById(result_id).value="Pass";
            break;
        case "TBD":
            window.opener.document.getElementById(result_id).value="TBD";
            break;
        case "In Progress":
            window.opener.document.getElementById(result_id).value="In Progress";
            window.opener.document.getElementById(status_id).value="In Progress";
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
    var MIN = (rowid-1)*number;
    var MAX = (rowid-1)*number+number;
    if(window.opener && !window.opener.closed){
        var status_txt = window.opener.document.getElementById("status"+(rowid-1));
        var result_txt = window.opener.document.getElementById("result"+(rowid-1));
        var reg1 = RegExp(/Fail/i);
        var ff = Array();
        for(var i=MIN; i<MAX; i++){
            var res_id = "subject18["+i+"]";
            var order_id = "test_order["+i+"]";
            var unit_result = window.opener.document.getElementById(res_id);
            var unit_order = window.opener.document.getElementById(order_id);
            if(unit_order.value!="" && !unit_result.value.match(reg1)){
                unit_result.value="Pass";
            }
        }
        status_txt.value = "Complete";
        for(var j=MIN; j<MAX; j++){
            var res_id = "subject18["+j+"]";
            var unit_result = window.opener.document.getElementById(res_id);
            ff.push(unit_result.value);
        }
        if(ff.includes("EC Fail")){
            result_txt.value = "EC Fail";
        }
        else if(ff.includes("Fail")){
            result_txt.value = "Fail";
        }
        else if(ff.includes("Known Fail (Open)")){
            result_txt.value = "Known Fail (Open)";
        }
        else if(ff.includes("Known Fail (Close)")){
            result_txt.value = "Known Fail (Close)";
        }
        else{
            result_txt.value = "Pass";
        }
        layer.msg("第"+rowid+"行除Fail外,全部設置為Pass",{icon: 6});
    }
    else{
        layer.msg("你关闭了Edit Matrix页面",{icon:5});
    }
}