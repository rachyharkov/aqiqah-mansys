@php
$meatId = '';
$offalId = '';
$riceId = '';
$eggId = '';
$vegieId = '';
$meatName = '';
$offalName = '';
$eggName = '';
$vegieName = '';
if ($order != '') {
    $packages = $order->orderPackage[$index];
    $meatName = $order->orderPackage[$index]->meat->meat->is_custom == true ? $order->orderPackage[$index]->meat->meat->name : '';
    $offalName = $order->orderPackage[$index]->offal->offal->is_custom == true ? $order->orderPackage[$index]->offal->offal->name : '';
    $eggName = $order->orderPackage[$index]->egg->egg->is_custom == true ? $order->orderPackage[$index]->egg->egg->name : '';
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
    if ($order->orderPackage[$index]->egg != '') {
        $eggId = $order->orderPackage[$index]->egg->egg->is_custom == true ? 'free_text' : $order->orderPackage[$index]->egg->egg->id;
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
                >-- Pilih Olahan Daging --</option>
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
                name="package[{{ $index }}][egg_menu]"
                class="form-control"
                id=""
                value="{{ $eggId }}"
                onchange="freeTextChange(this.value, 'egg')"
            >
                <option
                    value=""
                    selected
                    disabled
                >-- Pilih Menu Pilihan 1 --</option>
                @foreach ($eggs as $egg)
                    <option
                        value="{{ $egg->id }}"
                        {{ $eggId == $egg->id ? 'selected' : '' }}
                    >
                        {{ $egg->name }}
                    </option>
                @endforeach
                <option
                    value="free_text"
                    {{ $eggId == 'free_text' ? 'selected' : '' }}
                >Custom</option>
            </select>
        </div>
        <div
            class="col-6 {{ $eggId == 'free_text' ? '' : 'd-none' }}"
            id="egg_menu_input"
        >
            <label for="">Custom Telur</label>
            <input
                type="text"
                class="form-control"
                id="egg_menu_input_text"
                name="package[{{ $index }}][egg_menu_custom]"
                value="{{ $eggName }}"
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

<div class="col-12 form-group">
    <div class="row">
        <div class="col-6">
            <label for="">Nasi</label>
            <select
                name="package[{{ $index }}][rice_menu]"
                class="form-control"
                id=""
                value="{{ $riceId }}"
            >
                <option
                    value=""
                    selected
                    disabled
                >-- Pilih Nasi --</option>
                @foreach ($rices as $rice)
                    <option
                        value="{{ $rice->id }}"
                        {{ $riceId == $rice->id ? 'selected' : '' }}
                    >
                        {{ $rice->name }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
</div>
