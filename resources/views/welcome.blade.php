<div style="background: orchid">
@auth
    {{Auth::user()->name}}
    <a href="/logout">Logout</a>
@else
    <a href="/login">Login</a>
@endauth
</div>
@auth
<form method="POST" action="/upload" enctype="multipart/form-data">
    @csrf
    <input type="file" name="uploaded_file"/>
    <input type="submit" value="Upload">
    <table>
        <tr>
            <th></th>
            <th>Name</th>
            <th>Sizer</th>
            <th>Owner</th>
            <th>Created at</th>
            <th>Modified at</th>
        </tr>
        @foreach ($ficheros as $fichero)
        <tr>
            <td>
                @can('delete', $fichero)
                <a style="text-decoration: none" href="/delete/{{$fichero->id}}">🗑</td>
                @endcan
            <td><a href="/download/{{$fichero->id}}">{{$fichero->name}}</td>
            <td>{{$fichero->size()}}</td>
            <td>{{$fichero->user->name}}</td>
            <td>{{$fichero->create_at}}</td>
            <td>{{$fichero->modified_at}}</td>

        </tr>

        @endforeach
    </table>

</form>
@endauth
