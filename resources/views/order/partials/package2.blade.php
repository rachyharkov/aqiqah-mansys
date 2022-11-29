@php
$meatId = '';
$offalId = '';
$riceId = '';
$vegieId = '';
$offalName = '';
$meatName = '';
if ($order != '') {
    $packages = $order->orderPackage[$index];
    $meatName = $order->orderPackage[$index]->meat->meat->is_custom == true ? $order->orderPackage[$index]->meat->meat->name : '';
    $offalName = $order->orderPackage[$index]->offal->offal->is_custom == true ? $order->orderPackage[$index]->offal->offal->name : '';
    if ($order->orderPackage[$index]->meat != '') {
        $meatId = $order->orderPackage[$index]->meat->meat->is_custom == true ? 'free_text' : $order->orderPackage[$index]->meat->meat->id;
    }
    if ($order->orderPackage[$index]->offal != '') {
        $offalId = $order->orderPackage[$index]->offal->offal->is_custom == true ? 'free_text' : $order->orderPackage[$index]->offal->offal->id;
    }
    if ($order->orderPackage[$index]->rice != '') {
        $riceId = $order->orderPackage[$index]->rice->rice->id;
    }
    if ($order->orderPackage[$index]->vegie != '') {
        $vegieId = $order->orderPackage[$index]->vegie->vegie->id;
    }
}
@endphp
<div class="col-12">
    <div class="form-group row">
        <div class="col-6">
            <label for="">Olahan Daging</label>
            <select
                name="package[{{ $index }}][meat_menu]"
                class="form-control"
                id=""
                value="{{ $meatId }}"
                onchange="freeTextChange(this.value, 'meat')"
            >
                <option
                    value=""
                    selected
                    disabled
                >-- Pilih Olahan Daging --</option>
                @foreach ($meats as $d)
                    <option
                        value="{{ $d->id }}"
                        {{ $meatId == $d->id ? 'selected' : '' }}
                    >
                        {{ $d->name }}
                    </option>
                @endforeach
                <option
                    value="free_text"
                    {{ $meatId == 'free_text' ? 'selected' : '' }}
                >Custom</option>
            </select>
        </div>
        <div
            class="col-6 {{ $meatId == 'free_text' ? '' : 'd-none' }}"
            id="meat_menu_input"
        >
            <label for="">Custom Daging</label>
            <input
                type="text"
                class="form-control"
                id="meat_menu_input_text"
                name="package[{{ $index }}][meat_menu_custom]"
                value="{{ $meatName }}"
            >
        </div>
    </div>
</div>
<div class="col-12">
    <div class="form-group row">
        <div class="col-6">
            <label for="">Olahan Jeroan</label>
            <select
                name="package[{{ $index }}][offal_menu]"
                class="form-control"
                id=""
                value="{{ $offalId }}"
                onchange="freeTextChange(this.value, 'offal')"
            >
                <option
                    value=""
                    selected
                    disabled
                >-- Pilih Olahan Jeroan</option>
                @foreach ($offals as $offal)
                    <option
                        value="{{ $offal->id }}"
                        {{ $offalId == $offal->id ? 'selected' : '' }}
                    >
                        {{ $offal->name }}
                    </option>
                @endforeach
                <option
                    value="free_text"
                    {{ $offalId == 'free_text' ? 'selected' : '' }}
                >Custom</option>
            </select>
        </div>
        <div
            class="col-6 {{ $offalId == 'free_text' ? '' : 'd-none' }}"
            id="offal_menu_input"
        >
            <label for="">Custom Jeroan</label>
            <input
                type="text"
                class="form-control"
                id="offal_menu_input_text"
                name="package[{{ $index }}][offal_menu_custom]"
                value="{{ $offalName }}"
            >
        </div>
    </div>
</div>
<div class="col-12">
    <div class="form-group row">
        <div class="col-6">
            @php
                $rice = $rices->first();
            @endphp
            <label for="">Nasi</label>
            <input
                type="hidden"
                name="package[{{ $index }}][rice_menu]"
                value="{{ $rice->id }}"
            >
            <input
                type="text"
                class="form-control"
                value="{{ $rice->name }}"
                disabled
            >
        </div>
    </div>
</div>
