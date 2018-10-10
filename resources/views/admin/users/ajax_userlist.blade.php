@if(!empty($users))
    @foreach($users as $user)
    <tr>
        <td>{{ $user->first_name }}</td>
        <td >{{ $user->emailId }}</td>
        <td>{{ $user->mobileNumber }}</td>
        <td>{{ $user->id }}</td>
    </tr>
    @endforeach
@endif

