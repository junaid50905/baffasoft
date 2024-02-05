@include('partials.messages')
<form action="{{route('member-details.index')}}" method="get">
    <input type="text" name="search">
    <button>Search</button>
</form>
{{--{{Form::open(['route'=>'member-details.index','class'=>'contact-form form-horizontal','method'=>'GET','name'=>'newMember'])}}--}}
{{--<button>Delete</button>--}}
{{--{{Form::close()}}--}}

<table>
    @foreach($members as $member)
        <tr>
            <td>{{$member->id}}</td>
            <td>{{$member->username}}</td>
            <td>{{$member->email}}</td>
            <td>{{$member->organization_name}}</td>
            @if( $member->member_detail()->exists())
                <td>{{$member->member_detail->id}}</td>
                <td>{{$member->member_detail->member_id}}</td>
{{--                <td>{{$member->member_detail->firm_name}}</td>--}}
                <td>{{$member->member_detail->form_submit_date}}</td>
                <td><img src="{{asset($member->member_detail->attach_id_card_or_passport)}}" width="100" height="100">
                </td>
                <td><a href="{{route('member-details.edit',$member->member_detail->id)}}">EDIT</a></td>
                <td>
                    {{Form::open(['route'=>['member-details.delete',$member->member_detail->id],'class'=>'contact-form form-horizontal','method'=>'DELETE','name'=>'newMember','files' => true])}}
                    <button>Delete</button>
                    {{Form::close()}}
                </td>

            @endif
        </tr>
        <tr>
            <form action="{{route('member-details.change_pass',$member->id)}}" method="post">
                @csrf
                <td><input type="password" name="password" id=""></td>
                <td><input type="password" name="password_confirmation" id=""></td>
                <td><button>Submit</button></td>
            </form>
            <td></td>
        </tr>
    @endforeach
</table>
