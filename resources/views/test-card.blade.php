<style>
    #div-dashboard p{
        font-style: normal;
        font-weight: bold;
        font-size: 19px;
        line-height: 24px;
        color: #9FA2B4;
    }
    .small-box{
        background-color: #fff;
    }
    .inner{
        text-align: center;
    }
    .box-active{
        border: 1px solid #3751FF;
    }
    .box-active p, .box-active h3{
        color: #3751FF;
    }
</style>
<div id="div-dashboard">
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box">
                <div class="inner">
                    <p>Total</p>
                    <h3>{{ $totalOrders }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box">
                <div class="inner">
                    <p>Instagram</p>
                    <h3>{{ $totalInstagramOrders }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box">
                <div class="inner">
                    <p>Facebook</p>
                    <h3>{{ $totalFacebookOrders }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box">
                <div class="inner">
                    <p>Google</p>
                    <h3>{{ $totalGoogleOrders }}</h3>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box">
                <div class="inner">
                    <p>Others</p>
                    <h3>{{ $totalOthersOrders }}</h3>
                </div>
            </div>
        </div>
    </div>
</div>
