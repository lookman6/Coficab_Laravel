<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title>Le formulaire d'envoi du message</title>
</head>
<body>

	@if (session()->has('text'))
	<p>{{ session('text') }}</p>
	@endif
 	Hello, Nous vous avons créé un compte pour l'administration du site de gestion
	de formation de COFICAB. Vos identifiants sont les suivants: 
		
	<p>
		<b>email : {{$data["email"]}}</b> <br>
		<b>mot de passe : {{$data["password"]}}</b><br>
		<b>Merci de ne pas oublier de changer votre mot de passe</b>
	</p>  
	

</body>
</html>