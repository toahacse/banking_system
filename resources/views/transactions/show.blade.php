<x-app-layout>
    <x-slot name="header">
        <div class="row m-0 p-0">
            <div class="col-md-12">
                <div class="card ">
                    <div class="card-header header-elements-inline" style="background-color: #324148 !important">
                        <h5 class="card-title text-light">Transaction List <span style="float: right">Available Balance: {{ number_format($transactions[0]->user->balance ?? 0, 2, '.', ',') }} TK</span></h5>
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
                                @foreach($transactions as $transaction)
                                    <tr>
                                        <th scope="row">{{ $loop->iteration }}</th>
                                        <td>{{ $transaction->user->name }}</td>
                                        <td>{{ $transaction->transaction_type }}</td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->fee }}</td>
                                        <td>{{ $transaction->date }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </x-slot> 
</x-app-layout>