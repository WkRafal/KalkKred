{extends file=$conf->root_path|cat:"/templates/main.tlp"}

{block name=footer}przykładowa tresć stopki wpisana do szablonu głównego z szablonu kalkulatora{/block}

{block name=content}

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

<div class="messages">

    {* wyświeltenie listy błędów, jeśli istnieją *}
    {if $msgs->isError()} 
	<h4>Wystąpiły błędy: </h4>
	<ol class="err">
	{foreach  $msgs->getErrors() as $err}
	{strip}
            <li>{$err}</li>
	{/strip}
	{/foreach}
	</ol>
    {/if}

    {* wyświeltenie listy informacji, jeśli istnieją *}
    {if $msgs->isInfo()}
	<h4>Informacje: </h4>
	<ol class="inf">
	{foreach  $msgs->getInfos() as $info}
	{strip}
            <li>{$info}</li>
	{/strip}
	{/foreach}
	</ol>
    {/if}

    {if isset($result->result)}
	<h4>Wynik</h4>
	<p class="res">
	{$result->result}
	</p>
    {/if}

</div>

{/block}