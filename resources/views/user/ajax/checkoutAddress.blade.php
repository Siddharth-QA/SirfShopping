@foreach ($adds as $add)
    <div class="row align-items-center list">
        <div class="col-md-1 col-sm-1">
            <input type="checkbox" class="pr-2 billingCheckbox" value="{{ $add->id }}" name="pdt_id">
        </div>
        <div class="col-md-10 col-sm-10">
            <span> <span class="head">{{ Auth::user()->first_name }}
                    {{ Auth::user()->last_name }} - {{ $add->mobile }}</span>
                <br> {{ $add->address }} {{ $add->label }} {{ $add->city }}
                {{ $add->state }} {{ $add->pin_code }}</span>
        </div>
        <div class="col-md-1 col-sm-1 text-right edit">
            <a href="#">Edit</a>
        </div>
    </div>
    <hr class="hr">
@endforeach
<button type="button" data-toggle="collapse" 
class="collapsed btn-upper btn btn-primary checkout-page-button checkout-deliver checkout-continue"
data-parent="#accordion" href="#collapseFive">Continue
</button>
