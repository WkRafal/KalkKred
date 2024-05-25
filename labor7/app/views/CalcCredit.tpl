{extends file="main.tpl"}

{block name=footer}przykładowa tresć stopki wpisana do szablonu głównego z szablonu kalkulatora{/block}

{block name=content}
    
    <div class="pure-menu pure-menu-horizontal bottom-margin">
	<a href="{$conf->action_url}logout"  class="pure-menu-heading pure-menu-link">wyloguj</a>
        <a href="{$conf->action_url}results"  class="pure-menu-heading pure-menu-link">historia</a>
	<span style="float:right;">użytkownik: {$user->login}, rola: {$user->role}</span>
    </div>

<h3>Kalkulator kredytowy</h3>


<form class="pure-form pure-form-stacked" action="{$conf->action_root}calcCredit" method="post">
	<fieldset>
		<label for="amount">Kwota kredytu</label>
                <input id="amount" type="text" placeholder="kwota kredytu" name="amount" value="{$form->amount}">
		<label for="numOfInst">Liczba rat</label>
                <input id="numOfInst" type="text" placeholder="liczba rat" name="numOfInst" value="{$form->numOfInst}">
                <label for="interest">Oprocentowanie</label>
                <input id="interest" type="text" placeholder="oprocentowanie" name="interest" value="{$form->interest}">
	</fieldset>
	<button type="submit" class="pure-button pure-button-primary">Oblicz</button>
</form>

{include file='messages.tpl'}

{if isset($result->result)}
<div>
	<h4>Wynik</h4>
	<p class="res">
	{$result->result}
	</p>
</div>
{/if}

{/block}