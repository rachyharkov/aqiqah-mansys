@php
$meatId = '';
$offalId = '';
$riceId = '';
$chickenId = '';
$vegieId = '';
$meatName = '';
$offalName = '';
$chickenName = '';
$vegieName = '';
if ($order != '') {
    $packages = $order->orderPackage[$index];
    $meatName = $order->orderPackage[$index]->meat->meat->is_custom == true ? $order->orderPackage[$index]->meat->meat->name : '';
    $offalName = $order->orderPackage[$index]->offal->offal->is_custom == true ? $order->orderPackage[$index]->offal->offal->name : '';
    $chickenName = $order->orderPackage[$index]->chicken->chicken->is_custom == true ? $order->orderPackage[$index]->chicken->chicken->name : '';
    $vegieName = $order->orderPackage[$index]->vegie->vegie->is_custom == true ? $order->orderPackage[$index]->vegie->vegie->name : '';
    if ($order->orderPackage[$index]->meat != '') {
        $meatId = $order->orderPackage[$index]->meat->meat->is_custom == true ? 'free_text' : $order->orderPackage[$index]->meat->meat->id;
    }
    if ($order->orderPackage[$index]->offal != '') {
        $offalId = $order->orderPackage[$index]->offal->offal->is_custom == true ? 'free_text' : $order->orderPackage[$index]->offal->offal->id;
    }
    if ($order->orderPackage[$index]->rice != '') {
        $riceId = $order->orderPackage[$index]->rice->rice->id;
    }
    if ($order->orderPackage[$index]->chicken != '') {
        $chickenId = $order->orderPackage[$index]->chicken->chicken->is_custom == true ? 'free_text' : $order->orderPackage[$index]->chicken->chicken->id;
    }
    if ($order->orderPackage[$index]->vegie != '') {
        $vegieId = $order->orderPackage[$index]->vegie->vegie->is_custom == true ? 'free_text' : $order->orderPackage[$index]->vegie->vegie->id;
    }
}
@endphp
<div class="col-12 form-group">
    <div class="row">
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

<div class="col-12 form-group">
    <div class="row">
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

<div class="col-12 form-group">
    <div class="row">
        <div class="col-6">
            <label for="">Menu Pilihan 1</label>
            <select
                name="package[{{ $index }}][chicken_menu]"
                class="form-control"
                id=""
                value="{{ $chickenId }}"
                onchange="freeTextChange(this.value, 'chicken')"
            >
                <option
                    value=""
                    selected
                    disabled
                >-- Pilih Menu Pilihan 1 --</option>
                @foreach ($chickens as $chicken)
                    <option
                        value="{{ $chicken->id }}"
                        {{ $chickenId == $chicken->id ? 'selected' : '' }}
                    >
                        {{ $chicken->name }}
                    </option>
                @endforeach
                <option
                    value="free_text"
                    {{ $chickenId == 'free_text' ? 'selected' : '' }}
                >Custom</option>
            </select>
        </div>
        <div
            class="col-6 {{ $chickenId == 'free_text' ? '' : 'd-none' }}"
            id="chicken_menu_input"
        >
            <label for="">Custom Menu Pilihan 1</label>
            <input
                type="text"
                class="form-control"
                id="chicken_menu_input_text"
                name="package[{{ $index }}][chicken_menu_custom]"
                value="{{ $chickenName }}"
            >
        </div>
    </div>
</div>

<div class="col-12 form-group">
    <div class="row">
        <div class="col-6">
            <label for="">Menu Pilihan 2</label>
            <select
                name="package[{{ $index }}][vegetable_menu]"
                class="form-control"
                onchange="freeTextChange(this.value, 'vegetable')"
            >
                <option
                    value=""
                    selected
                    disabled
                >-- Pilih Menu Pilihan 2 --</option>
                @foreach ($vegies as $vegie)
                    <option
                        value="{{ $vegie->id }}"
                        {{ $vegieId == $vegie->id ? 'selected' : '' }}
                    >
                        {{ $vegie->name }}
                    </option>
                @endforeach
                <option
                    value="free_text"
                    {{ $vegieId == 'free_text' ? 'selected' : '' }}
                >Custom</option>
            </select>
        </div>
        <div
            class="col-6 {{ $vegieId == 'free_text' ? '' : 'd-none' }}"
            id="vegetable_menu_input"
        >
            <label for="">Custom Menu Pilihan 2</label>
            <input
                type="text"
                class="form-control"
                id="vegetable_menu_input_text"
                name="package[{{ $index }}][vegetable_menu_custom]"
                value="{{ $vegieName }}"
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
