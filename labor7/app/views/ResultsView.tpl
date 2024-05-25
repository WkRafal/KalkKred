{extends file="main.tpl"}

{block name=footer}przykładowa tresć stopki wpisana do szablonu głównego z szablonu kalkulatora{/block}

{block name=content}
    
    <div class="pure-menu pure-menu-horizontal bottom-margin">
	<a href="{$conf->action_url}logout"  class="pure-menu-heading pure-menu-link">wyloguj</a>
        <a href="{$conf->action_url}calcCredit"  class="pure-menu-heading pure-menu-link">kalkulator</a>
	<span style="float:right;">użytkownik: {$user->login}, rola: {$user->role}</span>
    </div>

<h3>Historia</h3>

    <div>
        <table style="width:100%">
	{foreach $results as $result}
	<tr>
		<td>id: {$result["idwynik"]}</td>
                <td>kwota: {$result["kwota"]}</td>
                <td>ilosc rat: {$result["raty"]}</td>
                <td>oprocentowanie: {$result["procent"]}</td>
                <td>rata: {$result["rata"]}</td>
                <td>data: {$result["data"]}</td>
	</tr>
	{/foreach}
        </table>
	
    </div>

{/block}
S