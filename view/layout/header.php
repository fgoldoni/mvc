<!DOCTYPE html>
<html>
<head>
	<title>Shop</title>
	<meta charset="utf-8">
        <link rel="stylesheet" href="<?php  echo BASE_URL.'/css/shop.css';?>" >   
</head>

<body>

<div id="header">
	<div class="wrap">
		<div class="menu">
                    <a href="<?=Router::url('products/index');?>" class="logo"><span class="glyphicon glyphicon-home"></span> Home</a>
				<h1>Le top de la vente, En ligne.</h1>
				<ul class="panier">
					<li class="caddie"><a href="<?php
                                        if($this->Session->isLogged()){                                         
                                        echo Router::url('products/panier');                                        
                                        }  else {                                          
                                          echo Router::url('users/register');
                                        }
                                        
                                        ?>"<?php  if(!$this->Session->isLogged()) echo "title= 'Connetez vous pour acceder au panier !'";?>>Caddie</a></li>
					<li class="items">
						ITEMS
						<span id="count"><?php
                                                if($this->Session->isLogged()){
                                                echo isset($count)? $count:'';
                                                }  else {
                                                    echo '0';
                                                }
                                                ?></span>
					</li>
					<li class="total">
						TOTAL
                                                <span id="total" ><?php
                                                if($this->Session->isLogged()){
                                                echo isset($total)? number_format($total,2,',',' '):'';
                                                }  else {
                                                    echo '0';
                                                }
                                                ?>€</span>
					</li>
				</ul>
		</div>
	</div>
</div>


<div id="wrap">