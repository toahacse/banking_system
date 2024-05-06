<x-app-layout>
    <x-slot name="header">
        <div class="row m-0 p-0">
            <div class="col-md-7">
                <div class="card ">
                    <div class="card-header header-elements-inline" style="background-color: #324148 !important">
                        <h5 class="card-title text-light">Withdrawal List <span style="float: right">Available Balance: {{ number_format($withdrawals[0]->user->balance ?? 0, 2, '.', ',') }} TK</span></h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">User Name</th>
                                <th scope="col">Transaction Type</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Fee</th>
                                <th scope="col">Date</th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach($withdrawals as $withdrawal)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $withdrawal->user->name }}</td>
                                        <td>{{ $withdrawal->transaction_type }}</td>
                                        <td>{{ number_format($withdrawal->amount ?? 0, 2, '.', ',') }} TK</td>
                                        <td>{{ number_format($withdrawal->fee ?? 0, 2, '.', ',') }} TK</td>
                                        <td>{{ $withdrawal->date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card ">
                    <div class="card-header header-elements-inline" style="background-color: #324148 !important">
                        <h5 class="card-title text-light">Withdrawal Add</h5>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form method="POST" action="{{ route('withdrawal.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="amount" id="amount" placeholder="0.00 Tk">
                            </div>
                            <div class="mt-2 justify-content-end d-flex">
                                <div>
                                    <button class="btn btn-primary btn-sm">{{ __('Withdrawal') }}</button>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </x-slot> 
</x-app-layout>