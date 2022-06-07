var script1 = document.createElement("script"); 
script1.type = "text/javascript"; 
script1.src = "js/jquery-3.6.0.min.js"; 
document.getElementsByTagName("head")[0].appendChild(script1);

var units_qty =""// document.getElementById("units_qty");
var counts = ""//units_qty.value;
var gg = ""    //用于保存option group的字符串
var tt = ""    //用于保存option test item的字符串
var arrayclass=Array();

function groupchange(aa){
    var el = document.getElementById("group"+aa).value;
    var check=0;
    var test_item = document.getElementById("test_item"+aa);
    var test_item_opt = test_item.options;

    if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) {
        var nodesSnapshot = document.evaluate("//select[@id='test_item"+aa+"']/option", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
        // alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
        if(nodesSnapshot.snapshotLength==57)
        {
            for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                var nodeA = nodesSnapshot.snapshotItem(i);
                var nodeclass=nodeA.getAttribute('class');
                arrayclass.push(nodeclass);
            }  
        }
        var nodesSnapshot = document.evaluate("//select[@id='test_item"+aa+"']/div", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
        for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
            var nodeA = nodesSnapshot.snapshotItem(i);
            //alert(arrayclass[i]);
            var elemA = document.createElement('option');
            elemA.innerHTML = nodeA.innerHTML;
            nodeA.parentNode.replaceChild(elemA, nodeA);
        }  

        var nodesSnapshot = document.evaluate("//select[@id='test_item"+aa+"']/option", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
        for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
            var nodeA = nodesSnapshot.snapshotItem(i);
            //alert(arrayclass[i]);
            var elemA = document.createElement('option');
            elemA.setAttribute("class",arrayclass[i])
            elemA.innerHTML = nodeA.innerHTML;
            nodeA.parentNode.replaceChild(elemA, nodeA);
        }
        var nodesSnapshot = document.evaluate("//select[@id='test_item"+aa+"']/option[@class!='"+el.slice(6,7)+"']", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
        for (var i = 1; i < nodesSnapshot.snapshotLength; i++) {
            var nodeA = nodesSnapshot.snapshotItem(i);
            var elemA = document.createElement('div');
            elemA.innerHTML = nodeA.innerHTML;
            nodeA.parentNode.replaceChild(elemA, nodeA);
        }       
    }
    for(var i=0; i<test_item_opt.length; i++){
        if(test_item_opt[i].getAttribute('class')!=el.slice(6,7)){
            test_item_opt[i].setAttribute("hidden",true);
        }
        else{
            if(check==0){
                document.getElementById("test_item"+aa).options[i].selected="selected"
            }
            test_item_opt[i].removeAttribute("hidden");
            check=1;
        }
        if(check==0){
            document.getElementById("test_item"+aa).options[0].selected="selected"
        }
    }
}

function innero(couts){
    // couts=Number(couts)+1;
    var rowCount=0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr")
    for (var i = 0; i < rows.length; i++) {
        if (rows[i].getElementsByTagName("td").length > 0) {
            rowCount=rowCount+1;
        }
    }
    
    if(couts<rowCount){
        for (var i = (rowCount); i > (couts); i--){
            for (var d = 1; d <(Number(counts)+1); d++){
                eval("original_select"+(i+1)+d+"=original_select"+(i)+d);
                eval("original_select"+(i)+d+"=''");
                //alert("i="+i+"d="+d);
                document.getElementById("test_order"+(i)+d).setAttribute("id","test_order"+(i+1)+d);
                document.getElementById("test_order"+(i+1)+d).setAttribute("onchange","testchange("+(i+1)+","+d+")");
            }

            document.getElementById("group"+(i)).setAttribute("id","group"+(i+1));
            document.getElementById("group"+(i+1)).setAttribute("onchange","groupchange("+(i+1)+")");
            document.getElementById("test_item"+(i)).setAttribute("id","test_item"+(i+1));
            document.getElementById((i)+"add").setAttribute("id",(i+1)+"add");                    
            document.getElementById((i)+"del").setAttribute("id",(i+1)+"del");
            document.getElementById((i+1)+"add").setAttribute("name",(i+1)+"add");
            document.getElementById((i+1)+"del").setAttribute("name",(i+1)+"del");           
        }
    }
    var gp="";
    gp+='<select name="group[]" id="group'+(couts+1)+'" onchange="groupchange('+(couts+1)+')">';
    gp+=gg;
    gp+='</select>';

    var ti="";
    var bu="";
    ti+='<select name="test_item[]" class="selbox" id="test_item'+(couts+1)+'">';
    ti+=tt;
    ti+='</select>';

    var table = document.getElementById("customers");
    var row = table.insertRow(couts+1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    cell1.innerHTML = gp;
    cell2.innerHTML = ti;

    for(var ii=1; ii<(Number(counts)+1); ii++){
        var to="";
        to+='<select class="test_order" name="test_order[]" id="test_order'+(couts+1)+ii+'" onchange="testchange('+(couts+1)+','+ii+')">';
        to+=this["oo"+ii] ;
        to+='</select>';
        row.insertCell(ii+1).innerHTML=to;
    }
    var rowCount=0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr")
    //alert("rows.length="+rows.length);
    for (var i = 0; i < rows.length; i++) {
        if (rows[i].getElementsByTagName("td").length > 0) {
            rowCount=rowCount+1;
        }
    }

    bu+='<input type="button" id="'+(couts+1)+'add"  name="'+(couts+1)+'add" class="btn_add" value="Add"/>&nbsp;&nbsp;<input type="button" id="'+(couts+1)+'del" name="'+(couts+1)+'del"  class="btn_del" value="Del" />'
    row.insertCell(ii+1).innerHTML=bu;

    $(':button[name='+(couts+1)+'add]').click(function(){
        var rowJavascript = this.parentNode.parentNode;
        var rowjQuery = $(this).closest("tr");

        var rowCount2=0;
        var table = document.getElementById("customers");
        var rows = table.getElementsByTagName("tr")
        //alert("rows.length="+rows.length);
        for (var i = 0; i < rows.length; i++) {
            if (rows[i].getElementsByTagName("td").length > 0) {
                rowCount2=rowCount2+1;
            }
        }
        innero(rowJavascript.rowIndex);
    })
    $(':button[name='+(couts+1)+'del]').click(function(){
        //coutI = coutI-1;
        var rowJavascript = this.parentNode.parentNode;
        var rowjQuery = $(this).closest("tr");
        couts=rowJavascript.rowIndex;

        var rowCount2=0;
        var table = document.getElementById("customers");
        var rows = table.getElementsByTagName("tr")
        for (var i = 0; i < rows.length; i++) {
            if (rows[i].getElementsByTagName("td").length > 0) {
                ////alert(rows[i].getElementsByTagName("td").length);
                rowCount2=rowCount2+1;
            }
        }

        for (var i = 1; i < (rowCount2+1); i++){
            for (var d = 1; d <(Number(counts)+1); d++){
                var deletorder= document.getElementById("test_order"+(couts)+d).value;
                const iindex = eval('arrcontainer'+d).indexOf(deletorder);

                if (iindex > -1) {
                    eval('arrcontainer'+d).splice(iindex, 1); // 2nd parameter means remove one item only
                }
                if(JSON.stringify($("#test_order"+i+d+" option[value='"+deletorder+"']").length) == 0 && deletorder!="请选择"){ 
                    for(var mm=1;mm<(eval("test_order"+i+d).options.length);mm++){
                        if(deletorder.charCodeAt(0)<eval("test_order"+i+d).options[mm].value.charCodeAt(0)){
                            eval("test_order"+i+d).options.add(new Option(deletorder,deletorder),eval("test_order"+i+d)[mm]);
                            break;
                        }
                    }
                }
             }
        }
         
        $(this).parents('tr').remove();

        for (var i = (couts+1); i < (rowCount2+1); i++){
            for (var d = 1; d <(Number(counts)+1); d++){
                document.getElementById("test_order"+(i)+d).setAttribute("id","test_order"+(i-1)+d);
                document.getElementById("test_order"+(i-1)+d).setAttribute("onchange","testchange("+(i-1)+","+d+")");
            }
            document.getElementById((i)+"add").setAttribute("id",(i-1)+"add");                    
            document.getElementById((i)+"del").setAttribute("id",(i-1)+"del");
            document.getElementById((i-1)+"add").setAttribute("name",(i-1)+"add");
            document.getElementById((i-1)+"del").setAttribute("name",(i-1)+"del");
        }
         
        for (var d = 1; d <(Number(counts)+1); d++){
            var test_order = document.getElementById("test_order1"+d);
            var test_order_opt = test_order.options;
            var arr_testorder=[];

            for(var i=0; i<test_order_opt.length; i++){
                if(eval("arrcontainer"+d).indexOf(test_order_opt[i].value)==-1){
                    arr_testorder.push(test_order_opt[i].value);
                }
            }     
            var p ="";
            eval("oo"+d+"=p");
             for(var j=0; j<arr_testorder.length; j++){
                //alert(eval("oo"+d));
                p= "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
                //alert(p);
                eval("oo"+d+"+=p");
                //alert(eval(S"oo"+d +"=<option value=arr_testorder["+j+"]>+arr_testorder["+j+"]+</option>")) ;
            }
        }             
    })
     
}

function testchange(pp,ii){
    var totalRowCount = 0;
    var rowCount = 0;
    var table = document.getElementById("customers");
    var rows = table.getElementsByTagName("tr")
    for (var i = 0; i < rows.length; i++) {
        totalRowCount++;
        if (rows[i].getElementsByTagName("td").length > 0) {
            rowCount=rowCount+1;
        }
    }

    var totalRowCount = rowCount;
    this["oo"+ii] = "" ; //dropdown list containter
    var arr_testorder = Array();
    var test_order = document.getElementById("test_order"+pp+ii);
    var strUser = test_order.value; //currently row two selecton item
    
    if(strUser!="请选择"){
        this["arrcontainer"+ii].push(strUser);
    }
    //alert(this["original_select"+pp+ii]);
    //alert("1this[original_select"+pp+ii+"]="+this["original_select"+pp+ii]);
    if(this["original_select"+pp+ii]==undefined||this["original_select"+pp+ii]==""){
        this["original_select"+pp+ii]=strUser;
        // alert("this[original_select"+pp+ii+"]="+this["original_select"+pp+ii]);
        for(var aa=1; aa<totalRowCount+1; aa++){
            if(JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length) > 0&&aa!==pp){
                $("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").remove();
            }
        }
    }
    else{
        if(this["original_select"+pp+ii]!="请选择"){
            for(var aa=1; aa<totalRowCount+1; aa++){
                if(this["original_select"+pp+ii]==undefined){
                    //this["select_temp"+ii]=strUser;
                }
                else{
                    var letterpo=this["original_select"+pp+ii].charCodeAt(0)-63;
                    const iindex = this["arrcontainer"+ii].indexOf(this["original_select"+pp+ii]);
                    if (iindex > -1) {
                        this["arrcontainer"+ii].splice(iindex, 1); // 2nd parameter means remove one item only
                    };
                    if(JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length) == 0){
                        
                        for(var mm=1;mm<(this["test_order"+aa+ii].options.length);mm++){
                            if(this["original_select"+pp+ii].charCodeAt(0)<this["test_order"+aa+ii].options[mm].value.charCodeAt(0)){
                                this["test_order"+aa+ii].options.add(new Option(this["original_select"+pp+ii],this["original_select"+pp+ii]),this["test_order"+aa+ii][mm]);
                                break;
                            }
                        }
                        //append original_selection back to container if not exit
                    }
                    else{
                        //alert("old original selec option exist!");
                        //test_order_ch.options.add(new Option(this["original selec"+ii],this["original selec"+ii]));
                    }
                }
            }
        }

        this["original_select"+pp+ii]=strUser; //set new testorder1 value
        // alert("orignial select"+pp+ii+ "="+this["original_select"+pp+ii]); //set new testorder1 value
        if(strUser!="请选择"){
            //this["original_select"+pp+ii]=strUser; //set new testorder1 value
            for(var aa=1; aa<totalRowCount+1; aa++){

                if(JSON.stringify($("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").length) > 0&&aa!=pp){
                    //alert("option exist!");
                    $("#test_order"+aa+ii+" option[value='"+this["original_select"+pp+ii]+"']").remove();
                }
            }
        }
    }
    var test_order_opt = test_order.options;

    for(var i=0; i<this["arrcontainer"+ii].length; i++){
      //  alert("unit num//content="+ii+"//"+ this["arrcontainer"+ii][i]);
    }
    for(var i=0; i<test_order_opt.length; i++){
        if(this["arrcontainer"+ii].indexOf(test_order_opt[i].value)==-1){
            arr_testorder.push(test_order_opt[i].value);
        }
    }
    for(var j=0; j<arr_testorder.length; j++){
        this["oo"+ii] += "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
    }
}

window.onload = function(){
    units_qty = document.getElementById("units_qty");
    counts = units_qty.value;
    var couts = 0;
    var coutI = 0;

    for(var i=0; i<counts; i++){
        w=i+1;
        //var arrcontainer =Array(); //collect select order
        this["arrcontainer"+w] = Array();
        this["oo"+w]="";
    }

    for(var i=1;i<50;i++){
        for(var ii=0; ii<counts; ii++){
            w=ii+1;
            //var arrcontainer =Array(); //collect select order
            this["original_select"+i+w] = "";    
        }

    }

    var arr_group = Array();
    var group = document.getElementById("group1");
    var group_opt = group.options;    //获得该下拉框所有的option的节点对象
    for(var i=0; i<group_opt.length; i++){
        arr_group.push(group_opt[i].value);
    }
    for(var j=0; j<arr_group.length; j++){
        gg += "<option>"+arr_group[j]+"</option>";
    }

    var arr_testitem = Array();
    var arr_testclass=Array();
    //test_item_opt[i].getAttribute('class')
    var test_item = document.getElementById("test_item1");
    var groupval = document.getElementById("group1").value;
    var test_item_opt = test_item.options;
    for(var i=0; i<test_item_opt.length; i++){
        arr_testitem.push(test_item_opt[i].value);
        arr_testclass.push(test_item_opt[i].getAttribute('class'));
    }
    for(var j=0; j<arr_testitem.length; j++){
        
        if(arr_testitem[j]!=""&&arr_testitem[j]!="Select_Item"){
            
            tt += "<option class="+arr_testclass[j].slice(6,7)+" hidden=true>"+arr_testitem[j]+"</option>";

        }
        else{
            tt += "<option class="+arr_testclass[j]+" hidden=true>"+arr_testitem[j]+"</option>";
        }
    }

    for(var e=0; e<counts; e++){
        ii=e+1;
        
        var arr_testorder = Array();
        var test_order = document.getElementById("test_order1"+ii);
        var strUser = test_order.value;
        if(strUser!="请选择"){
             this["arrcontainer"+ii].push(strUser);
        }
        var test_order_opt = test_order.options;
        for(var i=0; i<test_order_opt.length; i++){
                arr_testorder.push(test_order_opt[i].value);
        }
        for(var j=0; j<arr_testorder.length; j++){
            this["oo"+ii] += "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
        }
    }

    $(function(){

        $(':button[name=1add]').click(function(){
            var rowJavascript = this.parentNode.parentNode;
            var rowjQuery = $(this).closest("tr");
            //alert("JavaScript Row Index : " + (rowJavascript.rowIndex ) );
            innero(rowJavascript.rowIndex);
            var rowCount2=0;
            var table = document.getElementById("customers");
            var rows = table.getElementsByTagName("tr")
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].getElementsByTagName("td").length > 0) {
                    rowCount2=rowCount2+1;
                }
            }
        })
        $('button[name=del]').click(function(){
            $(this).parents('tr').remove();
        })

        $("#group1").on("change", function(){
            //var member_id = this.value;
            var el = $(this).find(':selected');
            var check=0;
            var test_item = document.getElementById("test_item1");
            var test_item_opt = test_item.options;
            
            if (navigator.userAgent.search("Safari") >= 0 && navigator.userAgent.search("Chrome") < 0) { 
                var nodesSnapshot = document.evaluate("//select[@id='test_item1']/option", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
                if(nodesSnapshot.snapshotLength==57){
                    for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                        var nodeA = nodesSnapshot.snapshotItem(i);
                        var nodeclass=nodeA.getAttribute('class');
                        arrayclass.push(nodeclass);
                    }  
                }
                var nodesSnapshot = document.evaluate("//select[@id='test_item1']/div", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
                for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                    var nodeA = nodesSnapshot.snapshotItem(i);
                    var elemA = document.createElement('option');
                    elemA.innerHTML = nodeA.innerHTML;
                    nodeA.parentNode.replaceChild(elemA, nodeA);
                }  

                var nodesSnapshot = document.evaluate("//select[@id='test_item1']/option", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
                for (var i = 0; i < nodesSnapshot.snapshotLength; i++) {
                    var nodeA = nodesSnapshot.snapshotItem(i);
                    var elemA = document.createElement('option');
                    elemA.setAttribute("class",arrayclass[i])
                    elemA.innerHTML = nodeA.innerHTML;
                    nodeA.parentNode.replaceChild(elemA, nodeA);
                }  

                var nodesSnapshot = document.evaluate("//select[@id='test_item1']/option[@class!='"+el.val()+"']", test_item, null, XPathResult.ORDERED_NODE_SNAPSHOT_TYPE, null);
                //alert("nodesSnapshot.snapshotLength="+nodesSnapshot.snapshotLength);
                for (var i = 1; i < nodesSnapshot.snapshotLength; i++) {
                    var nodeA = nodesSnapshot.snapshotItem(i);
                    var elemA = document.createElement('div');
                    elemA.innerHTML = nodeA.innerHTML;
                    nodeA.parentNode.replaceChild(elemA, nodeA);
                }       
            }
            for(var i=0; i<test_item_opt.length; i++){
                //test_item_opt[i].removeAttribute("hidden");
                //alert("class="+test_item_opt[i].getAttribute('class'));
                //if(test_item_opt[i].getAttribute('class')!=el.slice(6,7))
                if(test_item_opt[i].getAttribute('class')!=el.val()){
                    test_item_opt[i].setAttribute("hidden",true);
                }
                else{
                    if(check==0){
                        document.getElementById("test_item1").options[i].selected="selected"
                    }
                    test_item_opt[i].removeAttribute("hidden");
                    //if( ($(this).parent().is('span')) ) $(this).unwrap();
                    check=1;
                }
                if(check==0){
                    document.getElementById("test_item1").options[0].selected="selected"
                }
            }
        });
    })
    
    function addTr(couts){
        var html='';
        html+='<tr>';
        html+='<td><select name="group[]" id="group")>';
        html+=gg;
        html+='</select></td>';
       
        html+='<td><select name="test_item[]" class="selbox" id="test_item">';
        html+=tt;
        html+='</select></td>';
        counts
        for(var i=0; i<counts; i++){
            ii=i+1;
            html+='<td><select class="test_order" name="test_order[]" id="test_order'+(couts+1)+ii+'" onchange="testchange('+(couts+1)+','+ii+')">';
            html+=this["oo"+ii] ;
            html+='</select></td>';
            
        }
        var rowCount=0;
        var table = document.getElementById("customers");
        var rows = table.getElementsByTagName("tr")

        for (var i = 0; i < rows.length; i++) {
            if (rows[i].getElementsByTagName("td").length > 0) {
                rowCount=rowCount+1;
            }
        }
        html+='<td><input type="button" id="'+(rowCount+1)+'add"  name="'+(rowCount+1)+'add" class="btn_add" value="Add" />&nbsp;&nbsp;<input type="button" id="'+(rowCount+1)+'del" name="'+(rowCount+1)+'del"  class="btn_del" value="Del" /></td>';
        html+='<tr>';
        $('#customers').append(html);
        $(':button[name='+(rowCount+1)+'add]').click(function(){
            var rowCount2=0;
            var table = document.getElementById("customers");
            var rows = table.getElementsByTagName("tr")
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].getElementsByTagName("td").length > 0) {
                    rowCount2=rowCount2+1;
                }
            }
            addTr(rowCount2);
        })
        $(':button[name='+(rowCount+1)+'del]').click(function(){
            var rowJavascript = this.parentNode.parentNode;
            var rowjQuery = $(this).closest("tr");
            alert("JavaScript Row Index : " + (rowJavascript.rowIndex - 1) );
            var rowCount2=0;
            var table = document.getElementById("customers");
            var rows = table.getElementsByTagName("tr")
            for (var i = 0; i < rows.length; i++) {
                if (rows[i].getElementsByTagName("td").length > 0) {
                    rowCount2=rowCount2+1;
                }
            }
            for (var i = 1; i < (rowCount2+1); i++){

                for (var d = 1; d <(Number(counts)+1); d++){
                    var deletorder= document.getElementById("test_order"+(rowCount+1)+d).value;
                    const iindex = eval('arrcontainer'+d).indexOf(deletorder);
                    if (iindex > -1) {
                        eval('arrcontainer'+d).splice(iindex, 1); // 2nd parameter means remove one item only
                    }
                    if(JSON.stringify($("#test_order"+i+d+" option[value='"+deletorder+"']").length) == 0 && deletorder!="请选择"){
                        
                        for(var mm=1;mm<(eval("test_order"+i+d).options.length);mm++){
                            if(deletorder.charCodeAt(0)<eval("test_order"+i+d).options[mm].value.charCodeAt(0)){
                                eval("test_order"+i+d).options.add(new Option(deletorder,deletorder),eval("test_order"+i+d)[mm]);
                                break;
                            }
                        }
                        //append original_selection back to container if not exit
                    }
                }
            }
            $(this).parents('tr').remove();           
            
            for (var i = (rowCount+1); i < (rowCount2); i++){

                for (var d = 1; d <(Number(counts)+1); d++){
                    document.getElementById("test_order"+(i+1)+d).setAttribute("id","test_order"+(i)+d);
                    document.getElementById("test_order"+(i)+d).setAttribute("onchange","testchange("+(i)+","+d+")");
                }
                document.getElementById((i+1)+"add").setAttribute("id",i+"add");                    
                document.getElementById((i+1)+"del").setAttribute("id",i+"del");
                document.getElementById((i)+"add").setAttribute("name",(i)+"add");
                document.getElementById((i)+"del").setAttribute("name",(i)+"del");
            }
            for (var d = 1; d <(Number(counts)+1); d++){
                var test_order = document.getElementById("test_order1"+d);
                var test_order_opt = test_order.options;
                var arr_testorder=[];
                for(var i=0; i<test_order_opt.length; i++){
                    if(eval("arrcontainer"+d).indexOf(test_order_opt[i].value)==-1){
                        arr_testorder.push(test_order_opt[i].value);
                    }
                }
                var p ="";
                eval("oo"+d+"=p");
                for(var j=0; j<arr_testorder.length; j++){
                     p= "<option value="+arr_testorder[j]+">"+arr_testorder[j]+"</option>";
                    eval("oo"+d+"+=p");
                }
            }    
        })
    }
    // loading animation
    $(document).ready(function(){
        $("#form2").on("submit", function(){
            $("#preloder").fadeIn();
        });//submit
    });//document ready
}