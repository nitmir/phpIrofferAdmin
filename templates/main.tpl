{extends file="base.tpl"} 
{block name="title"}phpIroffer - desk{/block}
{block name="description"}phpIroffer index page{/block}
{block name="navbar"}
{include file='navbar.tpl' page='home'}
{/block}
{block name="container"}
      <h1>Bootstrap starter template</h1>
      <p>Use this document as a way to quick start any new project.<br> All you get is this message and a barebones HTML document.</p>
      <p> {$server}</p>
{/block}

