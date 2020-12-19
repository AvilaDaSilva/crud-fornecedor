@if (session()->has('successes'))
    <div class="alert alert-success">
        <strong>Sucesso na operação!</strong>
        <br>
        <ul>
            <li>{{session('successes')}}</li>
        </ul>
    </div>
@endif