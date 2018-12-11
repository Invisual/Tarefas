<?php include('headers.php'); ?>

<title>INVISUAL</title>

<style>
body{
	font-family: 'Raleway', sans-serif;
}

.regulamento h2{
	font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .02em;
}

.regulamento h5{
	width:70%;
	margin:50px auto 50px auto;
	max-width:900px;
	line-height:20px;
}

.main-text{
	width: 75%;
    margin: 100px auto 100px auto;
}

.main-text .seccao{
	margin-top:40px;
}

.main-text .seccao p{
	margin-left: 25px;
}

h4{
	position:unset;
}

.logo-regulamento{
	text-align:center;
	margin-top:120px;
}

.logo-regulamento img{
	width:300px;
}

</style>

<?php
header ('Content_type: text/html; charset=ISO-8859-1');

require_once ('utils/Autoloader.php');
session_start();

if($_SESSION['logged_in']==0){
	header('location:login.php');
}



?>
<?php include('navbar.php'); ?>

<body>

	<div class="container-fluid regulamento" style="position:relative; top:15vh;">
	
		<h2 class="text-center">Regulamento Interno</h2>

		<h5 class="text-center">O Regulamento Interno é um elemento criado para facilitar a organização dos recursos humanos da Agência, 
		de forma a melhorar a leitura organizacional e o cumprimento das regras que a direção da empresa pretende ver implementadas.</h5>

		<div class="main-text">

			<div class="seccao">
				<h4>1 - <strong>Horário de Funcionamento</strong></h4>
				<p>De 2ª a 6ª feira, das (9:30-13:00) e das (14:00-18:30).
				Tolerância de até 5 minutos e até 2 vezes por semana. Os restantes atrasos têm que ser compensados com tempo de trabalho.
				</p>
			</div>

			<div class="seccao">
				<h4>2 - <strong>Marcar dias de Férias</strong></h4>
				<p>Com o mínimo de 1 mês de antecedência e tem que ser aprovado pela Direção, não sendo, à partida, possível marcar em simultâneo com outros colegas. 
					Casos excecionais serão discutidos com a Direção da Agência. </p>
			</div>

			<div class="seccao">
				<h4>3 - <strong>Pedido de Dias</strong></h4>
				<p>Com 1 mês de antecedência e tem que ser aprovado pela Direção, não sendo, à partida possível marcar em simultâneo com outros colegas.
				Casos excecionais serão discutidos com a Direção da Agência</p>
			</div>

			<div class="seccao">
				<h4>4 - <strong>Atrasos ou Saídas antecipadas</strong></h4>
				<p>Enviar e-mail para Nuno, Bruna e Contabilidade. Estes atrasos serão compensados em horas de trabalho extra ou descontados em período de férias. 
				A decidir pela Direção.</p>
			</div>

			<div class="seccao">
				<h4>5 - <strong>Horas Extra</strong></h4>
				<p>Só com permissão da Direção da Agência e com a prévia definição da compensação correspondente. 
				</p>
			</div>

			<div class="seccao">
				<h4>6 - <strong>Intervalo de Manhã</strong></h4>
				<p>(10:30 – 10:45) ou/e  (11:30 – 11:45) – cada um reparte os seus 15 minutos nestes intervalos como quiser. 
					Se durante estes períodos estiverem em reuniões, podem fazer o intervalo logo de seguida. 
				</p>
			</div>

			<div class="seccao">
				<h4>7 - <strong>Intervalo da Tarde</strong></h4>
				<p>(16:00 – 16:15) ou (17:00 – 17:15) – cada um reparte os seus 15 minutos nestes intervalos como quiser.
				Se durante estes períodos estiverem em reuniões, podem fazer o intervalo logo de seguida. 
				</p>
			</div>

			<div class="seccao">
				<h4>8 - <strong>Telemóvel</strong></h4>
				<p>O uso de telemóvel pessoal só é possível se a pessoa se levantar e for obrigatoriamente para a zona de entrada. Se for para o exterior
				tem que marcar no relógio de ponto a saída e a entrada.
				</p>
			</div>

			<div class="seccao">
				<h4>9 - <strong>Relógio de Ponto</strong></h4>
				<p>Marcar: 
					<br>- entrada da manhã 
					<br>- intervalos da manhã
					<br>- saída para almoço 
					<br>- entrada da tarde
					<br>- intervalos da tarde 
					<br>- saída fim do dia 
					<br>- todas as saídas e entradas, de caráter pessoal, ao exterior.
				</p>
			</div>

			<div class="seccao">
				<h4>10 - <strong>Fumar</strong></h4>
				<p> Fora dos intervalos da manhã ou da tarde, é de evitar ir mais do que um elemento em simultâneo (para tornar o ato mais rápido), e 
				tem que ser registado no relógio de ponto a entrada e saída para ir fumar.
				</p>
			</div>

			<div class="seccao">
				<h4>11 - <strong>Alimentação</strong></h4>
				<p>É obrigatória na zona de entrada, sendo proibida nos postos de trabalho.
				</p>
			</div>

			<div class="seccao">
				<h4>12 - <strong>Arrumação de Mesas</strong></h4>
				<p>Para uma fácil higienização e para uma imagem cuidada dos diferentes postos de trabalho, cada mesa tem uma ocupação 
				máxima definida pelos equipamentos disponibilizados pela direção da Agência. O restante material deve ser guardado nos cacifos e nos locais 
				comuns para os diferentes efeitos.
				</p>
			</div>

			<div class="seccao">
				<h4>13 - <strong>Nota Final</strong></h4>
				<p>Este regulamento é sujeito a alterações que a direção da Agência considere pertinentes para o bom funcionamento do grupo de trabalho.</p>
			</div>

			<div class="logo-regulamento">
				<img src="img/logo-333.png" />
			</div>

		</div>

	</div>


</body>

</html>