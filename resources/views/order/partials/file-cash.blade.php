@php
    $proof = null;
    $kk = null;
    $ktp = null;
    if($order != "") {
        $proof = $order->proof_of_payment_img;
        $kk = $order->kk_img;
        $ktp = $order->ktp_img;
    }
@endphp
<div class="col-4">
    <label for="">Foto Bukti Pembayaran</label>
    @if ($isEdit)
        <input type="file"  name="proof_of_payment" id="input-file-max-fs" class="dropify" data-max-file-size="2M"
            data-allowed-file-extensions="png gif jpg jpeg" data-default-file="{{ asset($proof) }}"
            data-show-remove="false" onchange="manipulateStaticFileId()" />
        @else
            <input type="file"  name="proof_of_payment" id="input-file-max-fs" class="dropify" data-max-file-size="2M"
                data-allowed-file-extensions="png gif jpg jpeg" data-default-file=""
                data-show-remove="false"/>
    @endif
</div>
<div class="col-4">
    <label for="">Foto KTP</label>
    @if ($isEdit)
        <input type="file"  name="ktp" id="input-file-max-fs" class="dropify" data-max-file-size="2M"
            data-allowed-file-extensions="png gif jpg jpeg" data-default-file="{{ asset($ktp) }}"
            data-show-remove="false" onchange="manipulateStaticFileId()" />
    @else
        <input type="file"  name="ktp" id="input-file-max-fs" class="dropify" data-max-file-size="2M"
        data-allowed-file-extensions="png gif jpg jpeg" data-default-file=""
        data-show-remove="false"/>
    @endif
</div>
<div class="col-4">
    <label for="">Foto KK</label>
    @if ($isEdit)
        <input type="file"  name="kk" id="input-file-max-fs" class="dropify" data-max-file-size="2M"
        data-allowed-file-extensions="png gif jpg jpeg" data-default-file="{{ asset($kk) }}"
        data-show-remove="false" onchange="manipulateStaticFileId()" />
    @else
        <input type="file"  name="kk" id="input-file-max-fs" class="dropify" data-max-file-size="2M"
            data-allowed-file-extensions="png gif jpg jpeg" data-default-file="{{ asset($kk) }}"
            data-show-remove="false"/>
    @endif
</div>