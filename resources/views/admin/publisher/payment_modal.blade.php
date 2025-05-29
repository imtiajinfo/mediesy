<form action="" method="POST">
    @csrf
    <input type="hidden" name="shop_id" value="{{ $publisher->id }}">
    <div class="modal-header">
    	<h5 class="modal-title h6">{{__('Pay to seller')}}</h5>
    	<button type="button" class="close" data-dismiss="modal">
    	</button>
    </div>
    <div class="modal-body">
      <table class="table table-striped table-bordered" >
          <tbody>
              <tr>
                  @if($publisher->admin_to_pay >= 0)
                      <td>{{ __('Due to seller') }}</td>
                      <td>{{$publisher->admin_to_pay }}</td>
                  @else
                      <td>{{ __('Due to admin') }}</td>
                      <td>{{ abs($publisher->admin_to_pay) }}</td>
                  @endif
              </tr>
              @if ($publisher->bank_payment_status == 1)
                  <tr>
                      <td>{{ __('Bank Name') }}</td>
                      <td>{{ $publisher->bank_name }}</td>
                  </tr>
                  <tr>
                      <td>{{ __('Bank Account Name') }}</td>
                      <td>{{ $publisher->bank_acc_name }}</td>
                  </tr>
                  <tr>
                      <td>{{ __('Bank Account Number') }}</td>
                      <td>{{ $publisher->bank_acc_no }}</td>
                  </tr>
                  <tr>
                      <td>{{ __('Bank Routing Number') }}</td>
                      <td>{{ $publisher->bank_routing_no }}</td>
                  </tr>
              @endif
          </tbody>
      </table>

      @if ($publisher->admin_to_pay > 0)
          <div class="form-group row">
              <label class="col-md-3 col-from-label" for="amount">{{__('Amount')}}</label>
              <div class="col-md-9">
                  <input type="number" lang="en" min="0" step="0.01" name="amount" id="amount" value="{{ $publisher->admin_to_pay }}" class="form-control" required>
              </div>
          </div>

          <div class="form-group row">
              <label class="col-md-3 col-from-label" for="payment_option">{{__('Payment Method')}}</label>
              <div class="col-md-9">
                  <select name="payment_option" id="payment_option" class="form-control aiz-selectpicker" required>
                      <option value="">{{__('Select Payment Method')}}</option>
                      @if($publisher->cash_on_order_status == 1)
                          <option value="cash">{{__('Cash')}}</option>
                      @endif
                      @if($publisher->bank_payment_status == 1)
                          <option value="bank_payment">{{__('Bank Payment')}}</option>
                      @endif
                  </select>
              </div>
          </div>
          <div class="form-group row" id="txn_div">
              <label class="col-md-3 col-from-label" for="txn_code">{{__('Txn Code')}}</label>
              <div class="col-md-9">
                  <input type="text" name="txn_code" id="txn_code" class="form-control">
              </div>
          </div>
      @else
          <div class="form-group row">
              <label class="col-md-3 col-from-label" for="amount">{{__('Amount')}}</label>
              <div class="col-md-9">
                  <input type="number" lang="en" min="0" step="0.01" name="amount" id="amount" value="{{ abs($publisher->admin_to_pay) }}" class="form-control" required>
              </div>
          </div>
          <div class="form-group row" id="txn_div">
              <label class="col-md-3 col-from-label" for="txn_code">{{__('Txn Code')}}</label>
              <div class="col-md-9">
                  <input type="text" name="txn_code" id="txn_code" class="form-control">
              </div>
          </div>
      @endif
    </div>
    <div class="modal-footer">
      @if ($publisher->admin_to_pay > 0)
          <button type="submit" class="btn btn-primary">{{__('Pay')}}</button>
      @else
          <button type="submit" class="btn btn-primary">{{__('Clear due')}}</button>
      @endif
      <button type="button" class="btn btn-light" data-dismiss="modal">{{__('Cancel')}}</button>
    </div>
</form>

<script>
  $(document).ready(function(){
      $('#payment_option').on('change', function() {
        if ( this.value == 'bank_payment')
        {
          $("#txn_div").show();
        }
        else
        {
          $("#txn_div").hide();
        }
      });
      $("#txn_div").hide();
      AIZ.plugins.bootstrapSelect('refresh');
  });
</script>
