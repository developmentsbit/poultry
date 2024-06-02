<!DOCTYPE html>
<html>
<head>
  <title>Cash Close Report</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css">
</head>
<body>

  <div class="invoice">

    @component('components.report_banner')

    @endcomponent

    <center>
        <b>Cash Close Report</b>
        <br>
        <br>
    </center>

    <div class="container-fluid row">

        <div class="col-6">
            <div class="bg-success p-2 text-white text-center">
                Incomes
            </div>
            <table>
              <tr>
                <td colspan="3" style="text-align: center">Sales</td>
              </tr>
              <tr>
                <td>Date</td>
                <td>Invoice No</td>
                <td>Amount</td>
              </tr>
              @if($sales)
              @foreach ($sales as $s)
              <tr>
                <td>{{$s->invoice_date}}</td>
                <td>{{$s->invoice_no}}</td>
                <td>{{$s->paid_amount}}/-</td>
              </tr>
              @endforeach
              @endif
              <tr>
                <th colspan="2">Total</th>
                <th colspan="">{{$total_sales}}</th>
              </tr>
            </table>

            <br>
            <table>
              <tr>
                <td colspan="3" style="text-align: center">Customer Payment</td>
              </tr>
              <tr>
                <td>Date</td>
                <td>Details</td>
                <td>Amount</td>
              </tr>
              @if($customer_payment)
              @foreach ($customer_payment as $s)
              <tr>
                <td>{{$s->entry_date}}</td>
                <td>{{$s->note}}</td>
                <td>{{$s->payment_amount}}/-</td>
              </tr>
              @endforeach
              @endif
              <tr>
                <th colspan="2">Total</th>
                <th colspan="">{{$total_customer_payment}}</th>
              </tr>
            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Purchase Returns</td>
                  </tr>
                <tr>
                    <th colspan="2">Total Purchase Return</th>
                    <th>{{$purchase_returns}} /-</th>
                </tr>

            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Bank Withdraw</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Bank Name</td>
                    <td>Amount</td>
                </tr>
                @if($bank_withdraw)
                @foreach ($bank_withdraw as $b)
                <tr>
                    <td>{{$b->date}}</td>
                    <td>{{$b->bank_name}}</td>
                    <td>{{$b->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_bank_withdraw}}/-</th>
                </tr>
            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Bank Interest</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Bank Name</td>
                    <td>Amount</td>
                </tr>
                @if($bank_interset)
                @foreach ($bank_interset as $b)
                <tr>
                    <td>{{$b->date}}</td>
                    <td>{{$b->bank_name}}</td>
                    <td>{{$b->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_bank_interest}}/-</th>
                </tr>
            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Others Income</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Income Title</td>
                    <td>Amount</td>
                </tr>
                @if($income_entry)
                @foreach ($income_entry as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->title_en}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_income}}/-</th>
                </tr>
            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Loan Reciveds</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Loan Registers</td>
                    <td>Amount</td>
                </tr>
                @if($loan_recived)
                @foreach ($loan_recived as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_loan_recived}}/-</th>
                </tr>
            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Internal Loan Reciveds</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Loan Registers</td>
                    <td>Amount</td>
                </tr>
                @if($internal_loan_reciveds)
                @foreach ($internal_loan_reciveds as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_internal_loan_reciveds}}/-</th>
                </tr>
            </table>

        </div>

        <div class="col-6">
            <div class="bg-danger p-2 text-white text-center">
                Expense
            </div>

            <table>
                <tr>
                  <td colspan="3" style="text-align: center">Purchase</td>
                </tr>
                <tr>
                  <td>Date</td>
                  <td>Invoice No</td>
                  <td>Amount</td>
                </tr>
                @if($purchase)
                @foreach ($purchase as $s)
                <tr>
                  <td>{{$s->invoice_date}}</td>
                  <td>{{$s->invoice_no}}</td>
                  <td>{{$s->paid}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                  <th colspan="2">Total</th>
                  <th colspan="">{{$total_purchase}}</th>
                </tr>
              </table>

              <br>
            <table>
                <tr>
                  <td colspan="3" style="text-align: center">Supplier Payment</td>
                </tr>
                <tr>
                  <td>Date</td>
                  <td>Invoice No</td>
                  <td>Amount</td>
                </tr>
                @if($supplier_payment)
                @foreach ($supplier_payment as $s)
                <tr>
                  <td>{{$s->payment_date}}</td>
                  <td>{{$s->comment}}</td>
                  <td>{{$s->payment}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                  <th colspan="2">Total</th>
                  <th colspan="">{{$total_supplier_payment}}</th>
                </tr>
              </table>

              <br>

              <table>
                <tr>
                    <td colspan="3" style="text-align: center">Sales Returns</td>
                  </tr>
                <tr>
                    <th colspan="2">Total Sales Return</th>
                    <th>{{$sales_returns}} /-</th>
                </tr>

            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Others Expense</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Income Title</td>
                    <td>Amount</td>
                </tr>
                @if($others_expense)
                @foreach ($others_expense as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->title_en}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_expense}}/-</th>
                </tr>
            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Bank Deposit</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Bank Name</td>
                    <td>Amount</td>
                </tr>
                @if($bank_deposit)
                @foreach ($bank_deposit as $b)
                <tr>
                    <td>{{$b->date}}</td>
                    <td>{{$b->bank_name}}</td>
                    <td>{{$b->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_deposit}}/-</th>
                </tr>
            </table>


            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Bank Cost</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Bank Name</td>
                    <td>Amount</td>
                </tr>
                @if($bank_cost)
                @foreach ($bank_cost as $b)
                <tr>
                    <td>{{$b->date}}</td>
                    <td>{{$b->bank_name}}</td>
                    <td>{{$b->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_bank_cost}}/-</th>
                </tr>
            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Loan Provides</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Loan Registers</td>
                    <td>Amount</td>
                </tr>
                @if($loan_provide)
                @foreach ($loan_provide as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_loan_provide}}/-</th>
                </tr>
            </table>

            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Internal Loan Provide</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Loan Registers</td>
                    <td>Amount</td>
                </tr>
                @if($internal_loan_provide)
                @foreach ($internal_loan_provide as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->amount}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_internal_loan_provide}}/-</th>
                </tr>
            </table>


            <br>

            <table>
                <tr>
                    <td colspan="3" style="text-align: center">Salary Payment</td>
                  </tr>
                <tr>
                    <td>Date</td>
                    <td>Emplyoee Name</td>
                    <td>Amount</td>
                </tr>
                @if($salary_payment)
                @foreach ($salary_payment as $v)
                <tr>
                    <td>{{$v->date}}</td>
                    <td>{{$v->name}}</td>
                    <td>{{$v->salary_withdraw}}/-</td>
                </tr>
                @endforeach
                @endif
                <tr>
                    <th colspan="2">Total</th>
                    <th colspan="">{{$total_salary_payment}}/-</th>
                </tr>
            </table>

        </div>

        <div class="col-12">
            <br>
            <table>
                <tr>
                    <th>Total Collection</th>
                    <th>Total Expense</th>
                </tr>
                <tr>
                    <td>{{$total_incomes}}/-</td>
                    <td>{{$total_expenses}}/-</td>
                </tr>
            </table>
        </div>

    </div>
    <br>
    <br>
    <center><button class="btn btn-danger btn-sm print w-10" onclick="window.print();">Print</button></center>
    <br>

  </div>



</body>
</html>
