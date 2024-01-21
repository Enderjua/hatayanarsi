<?php include 'includes/header-main.php'; ?>

<script defer src="/assets/js/apexcharts.js"></script>
<div x-data="finance">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Banks</span>
        </li>
    </ul>
    <br>
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
    <div class="panel">
    <form class="space-y-5">
    <div>
        <label for="ctnSelect1">Banka'lar</label>
        <select id="ctnSelect1" class="form-select text-white-dark" required>
            <option>Ak bank</option>
            <option>Deniz bank</option>
            <option>Ziraat Bank</option>
            <option>Halk Bank</option>
            <option>Vakıf Bank</option>
            <option>Fiba bank</option>
            <option>Şeker bank</option>
            <option>iş Bank</option>
            <option>Yapı kredi</option>
            <option>Alternatif Bank</option>
            <option>Garanti bank</option>
            <option>HSBC Bank</option>
            <option>ICBC Bank</option>
            <option>ING Bank</option>
            <option>Odeabank</option>
            <option>Finans bank</option>
            <option>TEB Bank</option>
        </select>
    </div>
    <div>
        <label for="kapakText">Ad Soyad</label>
        <input id="kapakText" type="text" placeholder="Nativez Developer" class="form-input" required />
    </div>
    <div>
        <label for="detayText">İban</label>
        <input id="detayText" type="text" placeholder="TR640006269829789734764589" class="form-input" required />
    </div>
    <button type="submit" class="btn btn-primary !mt-6">Add</button>
</form>
</div>
<div class="panel">
                <div class="mb-5 text-lg font-bold">İban List</div>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th class="ltr:rounded-l-md rtl:rounded-r-md">ID</th>
                                <th>İsim Soyisim</th>
                                <th>İban</th>
                                <th class="text-center ltr:rounded-r-md rtl:rounded-l-md">#</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="font-semibold">#01</td>
                                <td class="whitespace-nowrap">Nativez Developer</td>
                                <td class="whitespace-nowrap">TR640006269829789734764589</td>
                                <td class="text-center">
                                <button type="button" class="btn btn-outline-primary btn-sm">Delete</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<?php include 'includes/footer-main.php'; ?>
