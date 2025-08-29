{{-- 

/**
*
* Created a new component <x-rtl.widgets._w-table-one/>.
* 
*/

--}}


<div class="widget widget-table-one">
    <div class="widget-heading">
        <h5 class="">{{ $title }}</h5>

    </div>

    <div class="widget-content">
        <div class="transactions-list">
            <div class="t-item">
                <div class="t-company-name">

                    <div class="t-name">
                        <h4>Toplam Ürün</h4>
                    </div>
                </div>
                <div class="t-rate rate-dec">
                    <p>
                        <span>
                            {{ $toplamVeriler['toplamUrun'] }}
                        </span>
                    </p>
                </div>
            </div>
        </div>


        <div class="transactions-list">
            <div class="t-item">
                <div class="t-company-name">

                    <div class="t-name">
                        <h4>Toplam Kategori</h4>
                    </div>
                </div>
                <div class="t-rate rate-dec">
                    <p>
                        <span>
                            {{ $toplamVeriler['toplamKategori'] }}
                        </span>
                    </p>
                </div>
            </div>
        </div>


        <div class="transactions-list">
            <div class="t-item">
                <div class="t-company-name">

                    <div class="t-name">
                        <h4>Toplam Kullanıcı</h4>
                    </div>
                </div>
                <div class="t-rate rate-dec">
                    <p>
                        <span>
                            {{ $toplamVeriler['toplamKullanici'] }}
                        </span>
                    </p>
                </div>
            </div>
        </div>


        <div class="transactions-list">
            <div class="t-item">
                <div class="t-company-name">

                    <div class="t-name">
                        <h4>Toplam Blog</h4>
                    </div>
                </div>
                <div class="t-rate rate-dec">
                    <p>
                        <span>
                            {{ $toplamVeriler['toplamBlog'] }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

    </div>
</div>
