{extends file="bot.tpl"}
{block name="assign"}{assign var="subpage" value="command"}{/block}
{block name="bot_title"}Admnistration shell{/block}
{block name="bot_description"}{/block}
{block name="bot_container"}
	<h2>Admnistration shell</h2>
	<script language="javascript">
var hist_cmd = new Array()
var hist_ptr = -1
var hist_last = ""
function scrollToBottom(elm_id){
	var elm=document.getElementById(elm_id);
	try{
		elm.scrollTop=elm.scrollHeight;
	}catch(e){
		var f=document.createElement("input");
		if(f.setAttribute)
			f.setAttribute("type","text")
		if(elm.appendChild)
			elm.appendChild(f);
		f.style.width="0px";
		f.style.height="0px";
		if(f.focus)
			f.focus();
		if(elm.removeChild)
			elm.removeChild(f);
	}
} 
function run(cmd) {
	var terminal = document.getElementById('terminal');
	terminal.innerHTML = terminal.innerHTML + cmd;
	if (hist_cmd[hist_cmd.length -1 ] != cmd) { 
		hist_ptr = hist_cmd.length;
		hist_cmd[hist_cmd.length] = cmd;
	} else {
		hist_ptr = hist_cmd.length - 1;
	}
	$.get("/xdcc/run_command.php", { id: "{$bot['id']}", command: cmd })
	.done(function(data) {
	terminal.innerHTML = terminal.innerHTML + "\n" + data;
	});
	scrollToBottom('terminal');
}

function send(){
	var value = document.getElementById('textbox1').value;
	document.getElementById('textbox1').value = '';
	if(value.length > 0 )
		run(value);
	setTimeout(function() {
		scrollToBottom('terminal');},500);
}

function stroke(code){
	if (code == 13)
		document.getElementById('btnsend').click();
	if (code == 38 && hist_ptr>-1) {
		document.getElementById('textbox1').value = hist_cmd[hist_ptr];
		hist_ptr = hist_ptr -1;
		hist_last = "up";
	}
	if (code == 40) {
		if (hist_last == "up")
			hist_ptr = hist_ptr + 1;
		if (hist_ptr<(hist_cmd.length-1) ){
		hist_ptr = hist_ptr + 1;
		document.getElementById('textbox1').value = hist_cmd[hist_ptr];
		} else {
			document.getElementById('textbox1').value = ''
		}
		hist_last = "down";
	}
}
		
</script>

<div class="terminal">
<pre class="terminal"><div id="terminal" >Welcome to {$bot['name']}

Entering DCC Chat Admin Interface
For Help type "help"
</div></pre>
<table width="100%" class="terminal">
<tr>
<!---->
<td class="terminal">
	<input name="textbox1" id="textbox1" type="text" class="input-medium terminal" 
	onkeydown="stroke(event.keyCode) "
	placeholder="Type something..." /></td>
<td><input name="btnsend" id="btnsend" onclick="send()" type="button" value="Send"  class="btn btn-primary" /></td>
</tr>
</table>
</div>
	
{/block}

