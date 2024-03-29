@include('AdminPanel.layouts.header')
<style type="text/css">
    .logo-title {
        margin-top:20px;
    }
</style>
<div class="login-page">
    <div class="login-box">
        <div class="login-logo" style="margin-bottom: 50px">
            <br>
            <span><img  width="150px" height="100px" src="{{url('dashboard/dist/img/AdminLTELogonew.png')}}"></span><a href="#"></a>
        </br>
        <h1 class="logo-title"><b>Mall Of Arabia</b></h1>
        </div>
        <!-- /.login-logo -->
        <div class="card">
            <div class="card-body login-card-body">
                <form action="{{route('handleLogin')}}" method="POST">
                    @include('AdminPanel.layouts.messages')
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email"  class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input id="password" type="password" name="password" class="form-control" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span id="togglePassword" class="fas fa-eye"></span>
                            </div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <select class="form-control" name="pc" required>
                            <option >select pc number</option>
                            @foreach($pcs as $pc)
                            <option value="{{$pc->id}}" >{{$pc->name}}</option>
                            @endforeach
                        </select>
                            <div class="input-group-text">
                                <span class="fas fa-desktop"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <!-- /.col -->
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block text-center">Sign In</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>
            </div>
            <!-- /.login-card-body -->
        </div>
    </div>
</div>
 @push('scripts')
<script>
    $(document).ready(function() {
        $('#togglePassword').click(function() {
            var passwordInput = $('#password');
            passwordInput.attr('type', passwordInput.attr('type') === 'password' ? 'text' : 'password');
              $(this).toggleClass('fa-eye fa-eye-slash');
        });
    });
</script>
@endpush
@include('AdminPanel.layouts.footer')
