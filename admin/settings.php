<?php include 'includes/header-main.php'; ?>

<script defer src="/assets/js/apexcharts.js"></script>
<div x-data="finance">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Settings</span>
        </li>
    </ul>
    <br>
    <div class="pt-5">
        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6 text-white">
            <!-- Phone Number -->
            <div class="panel">
                <div class="flex justify-between">
                    <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Phone Number</div>
                </div>
                <div class="flex items-center mt-5">
                <form>
                    <input type="tel" placeholder="90-(850)-111-2222" class="form-input" required />
                    <button type="submit" class="btn btn-primary mt-6">Save</button>
                </form>
                </div>
            </div>

            <!-- Whatsapp Number -->
            <div class="panel">
                <div class="flex justify-between">
                    <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Whatsapp Number</div>
                </div>
                <div class="flex items-center mt-5">
                <form>
                    <input type="tel" placeholder="90-(850)-111-2222" class="form-input" required />
                    <button type="submit" class="btn btn-primary mt-6">Save</button>
                </form>
                </div>
            </div>

            <!-- Admin Password -->
            <div class="panel">
                <div class="flex justify-between">
                    <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Admin Password</div>
                </div>
                <div class="flex items-center mt-5">
                <form>
                    <input type="tel" placeholder="admin123" class="form-input" required />
                    <button type="submit" class="btn btn-primary mt-6">Save</button>
                </form>
                </div>
            </div>

            <!-- Bounce Rate -->
            <div class="panel">
                <div class="flex justify-between">
                    <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Tawk.to Api</div>
                </div>
                <div class="flex items-center mt-5">
                <div>
                    <textarea id="ctnTextarea" rows="1" class="form-textarea" placeholder="Tawk.to api" required></textarea>
                    <button type="submit" class="btn btn-primary mt-6">Save</button>
                </div>
                </div>
            </div>
        </div>
<?php include 'includes/footer-main.php'; ?>
