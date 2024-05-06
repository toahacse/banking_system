<x-app-layout>
    <x-slot name="header">
        <div class="row m-0 p-0">
            <div class="col-md-7">
                <div class="card ">
                    <div class="card-header header-elements-inline" style="background-color: #324148 !important">
                        <h5 class="card-title text-light">Deposit List <span style="float: right">Available Balance: {{ number_format($deposits[0]->user->balance ?? 0, 2, '.', ',') }} TK</span></h5>
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
                                @foreach($deposits as $deposit)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $deposit->user->name }}</td>
                                        <td>{{ $deposit->transaction_type }}</td>
                                        <td>{{ number_format($deposit->amount ?? 0, 2, '.', ',') }} TK</td>
                                        <td>{{ number_format($deposit->fee ?? 0, 2, '.', ',') }} TK</td>
                                        <td>{{ $deposit->date }}</td>
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
                        <h5 class="card-title text-light">Deposit Add</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('deposit.store') }}">
                            @csrf
                            <div class="form-group">
                                <label for="amount">Amount</label>
                                <input type="number" class="form-control" name="amount" required id="amount" placeholder="0.00 Tk">
                            </div>
                            <div class="mt-2 justify-content-end d-flex">
                                <div class="float-right">
                                    <button class="btn btn-success btn-sm">{{ __('Deposit') }}</button>
                                </div>
                            </div>
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </x-slot> 
</x-app-layout>