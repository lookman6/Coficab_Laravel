@extends('layouts.mainlayout')

@section('content')
<p><a href="{{ route('personnels.index') }}" title="Liste du personnel" >Voir la liste du personnel</a></p>
    <div class="container">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">
                 {{$personnel->prenom}}  {{$personnel->nom}} <a href="{{ route('personnels.edit',$personnel) }}" title="modifier les données" >modifier</a>
                </h4>

                @isset($tab)
                <table class="table" >
            <thead>
                <tr>
                    <th>thème de formation</th>
                    <th  >date de début</th>
                    <th  >date de fin</th>
                    <th  >duree</th>
                    <th  >statut</th>
                </tr>
            </thead>
            <tbody>
                    
            
                @foreach ($tab as $seance )
                <tr>
                    <td>{{ $seance->formation->theme }}</td>
                    <td>{{ $seance->dateDebut }}</td>
                    <td>{{ $seance->dateFin }}</td>
                    <td>{{ $seance->duree }}</td>
                    @if( now()->format('Y-m-d') > $seance->dateFin )
                    <td><i class="bi bi-check-lg"></i></td>
                    @else
                    <td>
                        en cours
                    </td>
                    @endif
                </tr>
                @endforeach
            </tbody>
        </table>
        @endisset
            </div>
        </div>

    </div>
@endsection