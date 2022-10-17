<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Filieres</h1>
    @foreach($filieres as $filiere)
        <h2>{{$filiere->codeFiliere}}</h2>
        <h2>{{$filiere->responsableFiliere}}</h2>
        <a href="{{route('filieres.delete',$filiere)}}"><button type="button" class="btn_style btn_rouge btn-sm">Supprimer</button></a>
        <a href="{{route('filieres.edit',$filiere)}}"><button type="button" class="btn_style btn-sm">Editer</button></a>  
    @endforeach
</body>
</html>