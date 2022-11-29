<div class="card card-body card_package" id="card_package_{{ $id }}">
    <div class="floating_button d-none">
        <button class="btn btn-primary btn_add_package"
            type="button" id="btn_add_package_{{ $id }}"
            onclick="addPackage()"
        >
            +
        </button>
    </div>
    <div class="form-row">
        <div class="col">
            <label for="">Jenis Paket</label>
            <select name="package[{{ $id }}][package_id]" class="form-control"
                onchange="selectDetailPackage(this.value, {{ $id }})" id="">
                <option value="" selected disabled>-- Pilih Paket --</option>
                @foreach ($package as $pack)
                    <option value="{{ $pack->id }}">{{ $pack->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="form-row" id="target-package-detail-{{ $id }}"></div>
</div>