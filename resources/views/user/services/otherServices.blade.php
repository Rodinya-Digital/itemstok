@extends('layouts.SolarTheme')

@section('title')
    {{__('Other Services')}}
@endsection



@section('content')

    <div class="card p-3 p-md-4 shadow-sm">
        <div class="card-body">
            <label for="url" class="form-label fw-medium fs-5 mb-2">
                @if(auth()->user()->locale == 'tr')
                    İçerik URL'sini Girin:
                @elseif(auth()->user()->locale == 'en')
                    Enter Content URL:
                @elseif(auth()->user()->locale == 'es')
                    Ingrese la URL del Contenido:
                @elseif(auth()->user()->locale == 'bd')
                    কনটেন্ট URL লিখুন:
                @else {{-- Varsayılan dil (İngilizce veya istediğiniz başka bir dil) --}}
                Enter Content URL:
                @endif
            </label>
            <div class="input-group input-group-lg">
                <input type="text" class="form-control" id="url" name="url"
                       placeholder="
                       @if(auth()->user()->locale == 'tr')
                           İçerik bağlantısını buraya yapıştırın (örn. Shutterstock, Adobe Stock)...
                       @elseif(auth()->user()->locale == 'en')
                           Paste the link to the content here (e.g., Shutterstock, Adobe Stock)...
                       @elseif(auth()->user()->locale == 'es')
                           Pegue aquí el enlace al contenido (ej. Shutterstock, Adobe Stock)...
                       @elseif(auth()->user()->locale == 'bd')
                           কনটেন্টের লিঙ্কটি এখানে পেস্ট করুন (যেমন, শাটারস্টক, অ্যাডোবি স্টক)...
                       @else
                           Paste the link to the content here (e.g., Shutterstock, Adobe Stock)...
                       @endif
                   ">
                <button style="min-width: 120px;" class="btn btn-success" id="next">
                    <i class="fas fa-arrow-right me-1"></i>
                    @if(auth()->user()->locale == 'tr')
                        İleri
                    @elseif(auth()->user()->locale == 'en')
                        Next
                    @elseif(auth()->user()->locale == 'es')
                        Siguiente
                    @elseif(auth()->user()->locale == 'bd')
                        পরবর্তী
                    @else
                        Next
                    @endif
                </button>
            </div>
            <div class="form-text mt-2">
                @if(auth()->user()->locale == 'tr')
                    Sistem, sağlanan URL için ayrıntıları ve fiyatlandırma seçeneklerini almaya çalışacaktır.
                @elseif(auth()->user()->locale == 'en')
                    The system will attempt to fetch details and pricing options for the provided URL.
                @elseif(auth()->user()->locale == 'es')
                    El sistema intentará obtener los detalles y las opciones de precios para la URL proporcionada.
                @elseif(auth()->user()->locale == 'bd')
                    সিস্টেম প্রদত্ত URL-এর জন্য বিবরণ এবং মূল্যের বিকল্পগুলি আনার চেষ্টা করবে।
                @else
                    The system will attempt to fetch details and pricing options for the provided URL.
                @endif
            </div>
        </div>
    </div>



    {{-- İçerik Satın Alma Sistemi Hakkında Bilgilendirme Kartı --}}
    <div class="card mb-3 mb-lg-4 w-100 shadow-sm">
        <div class="card-body">
            @if(auth()->user()->locale=='tr')
                <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="fas fa-info-circle me-2 text-primary"></i> İçerik Satın Alma Sistemi Hakkında</h5>
                <ul class="list-unstyled lh-lg">
                    <li>🟢 <strong>Bakiyeniz Olmalı:</strong> <span class="text-muted">Bu hizmeti kullanabilmek için hesabınızda yeterli bakiye bulunmalıdır.</span></li>
                    <li>🔗 <strong>İçerik Bağlantısını Yapıştırın:</strong> <span class="text-muted">Sistem otomatik olarak içerik bilgilerini ve fiyatını getirecektir.</span></li>
                    <li>💰 <strong>Fiyat Seçeneklerini Görüntüleyin:</strong> <span class="text-muted">Farklı çözünürlük ve lisans seçenekleri listelenecektir.</span></li>
                    <li>🛒 <strong>Bir Seçenek Belirleyin:</strong> <span class="text-muted">Seçiminiz sonrası tutar bakiyenizden düşülür ve içerik teslim edilir.</span></li>
                    <li>⚠️ <strong>Sayfadan Ayrılmayın:</strong> <span class="text-muted">İndirme bağlantısı oluşturulana ve indirme başlayana kadar sayfada kalınız.</span></li>
                </ul>
            @elseif(auth()->user()->locale=='en')
                <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="fas fa-info-circle me-2 text-primary"></i> About the Content Purchase System</h5>
                <ul class="list-unstyled lh-lg">
                    <li>🟢 <strong>You Must Have a Balance:</strong> <span class="text-muted">You need sufficient balance in your account to use this service.</span></li>
                    <li>🔗 <strong>Paste the Content Link:</strong> <span class="text-muted">The system will automatically fetch content information and pricing.</span></li>
                    <li>💰 <strong>View Price Options:</strong> <span class="text-muted">Various resolution and license choices will be listed.</span></li>
                    <li>🛒 <strong>Select an Option:</strong> <span class="text-muted">The cost will be deducted from your balance, and the content delivered.</span></li>
                    <li>⚠️ <strong>Do Not Leave the Page:</strong> <span class="text-muted">Please stay on the page until the download link is generated and the download begins.</span></li>
                </ul>
            @elseif(auth()->user()->locale=='es')
                <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="fas fa-info-circle me-2 text-primary"></i> Sobre el Sistema de Compra de Contenido</h5>
                <ul class="list-unstyled lh-lg">
                    <li>🟢 <strong>Debe Tener Saldo:</strong> <span class="text-muted">Necesita saldo suficiente en su cuenta para utilizar este servicio.</span></li>
                    <li>🔗 <strong>Pegue el Enlace del Contenido:</strong> <span class="text-muted">El sistema obtendrá automáticamente la información y el precio del contenido.</span></li>
                    <li>💰 <strong>Ver Opciones de Precio:</strong> <span class="text-muted">Se mostrarán varias opciones de resolución y licencia.</span></li>
                    <li>🛒 <strong>Seleccione una Opción:</strong> <span class="text-muted">El costo se deducirá de su saldo y se entregará el contenido.</span></li>
                    <li>⚠️ <strong>No Cierre la Página:</strong> <span class="text-muted">Permanezca en la página hasta que se genere el enlace de descarga y comience la descarga.</span></li>
                </ul>
            @elseif(auth()->user()->locale=='bd')
                <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="fas fa-info-circle me-2 text-primary"></i> কনটেন্ট কেনার সিস্টেম সম্পর্কে</h5>
                <ul class="list-unstyled lh-lg">
                    <li>🟢 <strong>অ্যাকাউন্টে ব্যালেন্স থাকতে হবে:</strong> <span class="text-muted">এই পরিষেবাটি ব্যবহার করার জন্য আপনার অ্যাকাউন্টে পর্যাপ্ত ব্যালেন্স থাকতে হবে।</span></li>
                    <li>🔗 <strong>কনটেন্টের লিংক দিন:</strong> <span class="text-muted">সিস্টেম স্বয়ংক্রিয়ভাবে কনটেন্টের তথ্য এবং মূল্য আনবে।</span></li>
                    <li>💰 <strong>মূল্য অপশন দেখুন:</strong> <span class="text-muted">বিভিন্ন রেজোলিউশন এবং লাইসেন্সের অপশনগুলি তালিকাভুক্ত করা হবে।</span></li>
                    <li>🛒 <strong>একটি অপশন নির্বাচন করুন:</strong> <span class="text-muted">আপনার ব্যালেন্স থেকে মূল্য কেটে নেওয়া হবে এবং কনটেন্ট সরবরাহ করা হবে।</span></li>
                    <li>⚠️ <strong>পেজ ছাড়বেন না:</strong> <span class="text-muted">ডাউনলোড লিঙ্ক তৈরি না হওয়া পর্যন্ত এবং ডাউনলোড শুরু না হওয়া পর্যন্ত দয়া করে পেজে থাকুন।</span></li>
                </ul>
            @endif
        </div>
    </div>

    {{-- Desteklenen Servisler Kartı --}}
    <div class="card w-100 shadow-sm">
        <div class="card-body">
            @if(auth()->user()->locale=='tr')
                <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-2 text-success"></i> Desteklenen Servislerin Bir Kısmı</h5>
                <p class="text-muted">Aşağıda sistemimizde desteklenen bazı servisleri görebilirsiniz. Bu liste düzenli olarak güncellenmektedir.</p>
            @elseif(auth()->user()->locale=='en')
                <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-2 text-success"></i> Some of the Supported Services</h5>
                <p class="text-muted">Below are some of the services supported in our system. This list is updated regularly.</p>
            @elseif(auth()->user()->locale=='es')
                <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-2 text-success"></i> Algunos de los Servicios Soportados</h5>
                <p class="text-muted">A continuación, se muestran algunos de los servicios compatibles con nuestro sistema. Esta lista se actualiza regularmente.</p>
            @elseif(auth()->user()->locale=='bd')
                <h5 class="fw-bold mb-3 d-flex align-items-center"><i class="fas fa-check-circle me-2 text-success"></i> সমর্থিত কিছু পরিষেবা</h5>
                <p class="text-muted">নীচে আমাদের সিস্টেমে সমর্থিত কিছু পরিষেবার তালিকা দেওয়া হল। এই তালিকাটি নিয়মিত আপডেট করা হয়।</p>
            @endif

            <div class="row mt-4">
                <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                    <h6 class="fw-semibold d-flex align-items-center">
                        <i class="fas fa-image me-2"></i> @if(auth()->user()->locale=='tr') Görsel Servisleri
                        @elseif(auth()->user()->locale=='en') Image Services
                        @elseif(auth()->user()->locale=='es') Servicios de Imágenes
                        @elseif(auth()->user()->locale=='bd') ইমেজ সার্ভিস
                        @endif
                    </h6>
                    <ul class="list-unstyled small text-muted ps-3">
                        <li>Shutterstock</li><li>123RF</li><li>Adobe Stock</li><li>DepositPhotos</li><li>DreamsTime</li><li>Envato Elements</li><li>FreePik</li><li>IstockPhoto</li><li>PngTree</li><li>Motion Elements</li><li>Creative Fabrica</li><li>Deezy</li>
                        <li>ls.graphics</li><li>Designi</li><li>Flaticon</li><li>CraftWork</li><li>IconScout</li><li>PixelSquid</li><li>RawPixel</li><li>UI8</li><li>Vecteezy</li><li>Uplabs</li><li>Mockupcloud</li><li>Pixelbuddha</li><li>VectorStock</li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                    <h6 class="fw-semibold d-flex align-items-center">
                        <i class="fas fa-film me-2"></i> @if(auth()->user()->locale=='tr') Video Servisleri
                        @elseif(auth()->user()->locale=='en') Video Services
                        @elseif(auth()->user()->locale=='es') Servicios de Video
                        @elseif(auth()->user()->locale=='bd') ভিডিও সার্ভিস
                        @endif
                    </h6>
                    <ul class="list-unstyled small text-muted ps-3">
                        <li>Adobe Stock Video</li><li>StoryBlocks</li><li>Motion Array</li><li>FootageCrate</li>
                    </ul>

                    <h6 class="fw-semibold mt-3 d-flex align-items-center">
                        <i class="fas fa-music me-2"></i> @if(auth()->user()->locale=='tr') Müzik Servisleri
                        @elseif(auth()->user()->locale=='en') Music Services
                        @elseif(auth()->user()->locale=='es') Servicios de Música
                        @elseif(auth()->user()->locale=='bd') মিউজিক সার্ভিস
                        @endif
                    </h6>
                    <ul class="list-unstyled small text-muted ps-3">
                        <li>ArtGrid</li><li>ArtList</li><li>EpidemicSound</li><li>Shutterstock Music</li>
                    </ul>
                </div>

                <div class="col-lg-4 col-md-12"> {{-- Son öğe md'de tam genişlik alabilir --}}
                    <h6 class="fw-semibold d-flex align-items-center">
                        <i class="fas fa-hand-paper me-2"></i> @if(auth()->user()->locale=='tr') Manuel Servisler
                        @elseif(auth()->user()->locale=='en') Manual Services
                        @elseif(auth()->user()->locale=='es') Servicios Manuales
                        @elseif(auth()->user()->locale=='bd') ম্যানুয়াল সার্ভিস
                        @endif
                    </h6>
                    <ul class="list-unstyled small text-muted ps-3">
                        <li>Shutterstock Offset</li><li>Alamy</li><li>YellowImages</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

@endsection

{{-- Diğer Blade section'ları (@extends, @section('title'), @section('topbuttons'), @section('content')) --}}
{{-- Bir önceki yanıttaki gibi kalacak. Sadece @section('scripts') değişecek. --}}
{{-- Önceki yanıttaki Blade kodunun tamamını kullanıp sadece aşağıdaki @section('scripts') kısmını değiştirebilirsiniz. --}}

@section('scripts')
    {{-- Font Awesome ikonlarının SolarTheme layout'unuzda yüklü olduğunu varsayıyorum. --}}
    <script>
        const currentUserLocale = '{{ auth()->user()->locale }}'; // Kullanıcının dilini alıyoruz

        const allTranslations = {
            'en': {
                nolimitMessage: "You have reached your limit for this service or content type.",
                processingPurchaseTitle: "Processing Purchase...",
                processingPurchaseHtml: "Please wait while we process your request.",
                purchaseSuccessfulTitle: "Purchase Successful!",
                purchaseSuccessfulHtmlLine1: "Your content is ready for download.",
                downloadButtonText: "Download Content",
                downloadIfAutoFails: "If the download doesn't start automatically, click the button above.",
                purchaseFailedTitle: "Purchase Failed",
                purchaseFailedDefaultHtml: "Could not complete the purchase. Please check your balance or try again.",
                authErrorTitle: "Authentication Error",
                authErrorHtml: "Your session may have expired. Please reload the page and try again.",
                reloadButtonText: "Reload Page",
                genericErrorTitle: "Error",
                unknownErrorHtml: "An unknown error has occurred. Please try again later.",
                fetchingDetailsTitle: "Fetching Content Details...",
                fetchingDetailsHtml: "Please wait while we retrieve information about the content.",
                missingUrlTitle: "Missing URL",
                missingUrlHtml: "Please enter a content URL to proceed.",
                invalidUrlTitle: "Invalid URL",
                invalidUrlHtml: "Please enter a valid content URL.",
                providerText: "Provider",
                itemIdText: "Item ID",
                authorText: "Author",
                availableOptionsText: "Available Purchase Options:",
                noOptionsAvailableText: "No purchase options available for this item at the moment.",
                errorFetchingDetailsTitle: "Error Fetching Details",
                errorFetchingDefaultHtml: "Could not retrieve details for this URL. It might be unsupported or the link is incorrect.",
                unknownErrorFetchingDetailsHtml: "An unknown error has occurred while fetching details. Please try again later."
            },
            'tr': {
                nolimitMessage: "Bu servis veya içerik türü için limitinize ulaştınız.",
                processingPurchaseTitle: "Satın Alma İşleniyor...",
                processingPurchaseHtml: "Lütfen isteğiniz işlenirken bekleyin.",
                purchaseSuccessfulTitle: "Satın Alma Başarılı!",
                purchaseSuccessfulHtmlLine1: "İçeriğiniz indirilmeye hazır.",
                downloadButtonText: "İçeriği İndir",
                downloadIfAutoFails: "İndirme otomatik başlamazsa, yukarıdaki düğmeye tıklayın.",
                purchaseFailedTitle: "Satın Alma Başarısız",
                purchaseFailedDefaultHtml: "Satın alma tamamlanamadı. Lütfen bakiyenizi kontrol edin veya tekrar deneyin.",
                authErrorTitle: "Kimlik Doğrulama Hatası",
                authErrorHtml: "Oturumunuzun süresi dolmuş olabilir. Lütfen sayfayı yeniden yükleyip tekrar deneyin.",
                reloadButtonText: "Sayfayı Yeniden Yükle",
                genericErrorTitle: "Hata",
                unknownErrorHtml: "Bilinmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyin.",
                fetchingDetailsTitle: "İçerik Detayları Alınıyor...",
                fetchingDetailsHtml: "İçerik hakkında bilgi alınırken lütfen bekleyin.",
                missingUrlTitle: "URL Eksik",
                missingUrlHtml: "Devam etmek için lütfen bir içerik URL'si girin.",
                invalidUrlTitle: "Geçersiz URL",
                invalidUrlHtml: "Lütfen geçerli bir içerik URL'si girin.",
                providerText: "Sağlayıcı",
                itemIdText: "Öğe ID",
                authorText: "Yazar",
                availableOptionsText: "Mevcut Satın Alma Seçenekleri:",
                noOptionsAvailableText: "Şu anda bu öğe için kullanılabilir satın alma seçeneği bulunmamaktadır.",
                errorFetchingDetailsTitle: "Detayları Alırken Hata Oluştu",
                errorFetchingDefaultHtml: "Bu URL için detaylar alınamadı. Desteklenmiyor olabilir veya bağlantı yanlış.",
                unknownErrorFetchingDetailsHtml: "Detayları alırken bilinmeyen bir hata oluştu. Lütfen daha sonra tekrar deneyin."
            },
            'es': {
                nolimitMessage: "Ha alcanzado su límite para este servicio o tipo de contenido.",
                processingPurchaseTitle: "Procesando Compra...",
                processingPurchaseHtml: "Por favor, espere mientras procesamos su solicitud.",
                purchaseSuccessfulTitle: "¡Compra Exitosa!",
                purchaseSuccessfulHtmlLine1: "Su contenido está listo para descargar.",
                downloadButtonText: "Descargar Contenido",
                downloadIfAutoFails: "Si la descarga no comienza automáticamente, haga clic en el botón de arriba.",
                purchaseFailedTitle: "Falló la Compra",
                purchaseFailedDefaultHtml: "No se pudo completar la compra. Por favor, revise su saldo o inténtelo de nuevo.",
                authErrorTitle: "Error de Autenticación",
                authErrorHtml: "Su sesión puede haber expirado. Por favor, recargue la página e inténtelo de nuevo.",
                reloadButtonText: "Recargar Página",
                genericErrorTitle: "Error",
                unknownErrorHtml: "Ha ocurrido un error desconocido. Por favor, inténtelo de nuevo más tarde.",
                fetchingDetailsTitle: "Obteniendo Detalles del Contenido...",
                fetchingDetailsHtml: "Por favor, espere mientras recuperamos información sobre el contenido.",
                missingUrlTitle: "URL Faltante",
                missingUrlHtml: "Por favor, ingrese una URL de contenido para continuar.",
                invalidUrlTitle: "URL Inválida",
                invalidUrlHtml: "Por favor, ingrese una URL de contenido válida.",
                providerText: "Proveedor",
                itemIdText: "ID del Artículo",
                authorText: "Autor",
                availableOptionsText: "Opciones de Compra Disponibles:",
                noOptionsAvailableText: "No hay opciones de compra disponibles para este artículo en este momento.",
                errorFetchingDetailsTitle: "Error al Obtener Detalles",
                errorFetchingDefaultHtml: "No se pudieron obtener los detalles para esta URL. Puede que no sea compatible o que el enlace sea incorrecto.",
                unknownErrorFetchingDetailsHtml: "Ha ocurrido un error desconocido al obtener los detalles. Por favor, inténtelo de nuevo más tarde."
            },
            'bd': {
                nolimitMessage: "আপনি এই পরিষেবা বা বিষয়বস্তুর প্রকারের জন্য আপনার সীমা পৌঁছেছেন।",
                processingPurchaseTitle: "ক্রয় প্রক্রিয়া চলছে...",
                processingPurchaseHtml: "অনুগ্রহ করে অপেক্ষা করুন যতক্ষণে আমরা আপনার অনুরোধ প্রক্রিয়া করছি।",
                purchaseSuccessfulTitle: "ক্রয় সফল!",
                purchaseSuccessfulHtmlLine1: "আপনার কনটেন্ট ডাউনলোডের জন্য প্রস্তুত।",
                downloadButtonText: "কনটেন্ট ডাউনলোড করুন",
                downloadIfAutoFails: "যদি ডাউনলোড স্বয়ংক্রিয়ভাবে শুরু না হয়, উপরের বাটনে ক্লিক করুন।",
                purchaseFailedTitle: "ক্রয় ব্যর্থ হয়েছে",
                purchaseFailedDefaultHtml: "ক্রয় সম্পন্ন করা যায়নি। অনুগ্রহ করে আপনার ব্যালেন্স চেক করুন অথবা আবার চেষ্টা করুন।",
                authErrorTitle: "প্রমাণীকরণ ত্রুটি",
                authErrorHtml: "আপনার সেশনের মেয়াদ শেষ হয়ে থাকতে পারে। অনুগ্রহ করে পৃষ্ঠাটি পুনরায় লোড করুন এবং আবার চেষ্টা করুন।",
                reloadButtonText: "পৃষ্ঠাটি পুনরায় লোড করুন",
                genericErrorTitle: "ত্রুটি",
                unknownErrorHtml: "একটি অজানা ত্রুটি ঘটেছে। অনুগ্রহ করে পরে আবার চেষ্টা করুন।",
                fetchingDetailsTitle: "কনটেন্টের বিবরণ আনা হচ্ছে...",
                fetchingDetailsHtml: "অনুগ্রহ করে অপেক্ষা করুন যতক্ষণে আমরা কনটেন্ট সম্পর্কে তথ্য পুনরুদ্ধার করছি।",
                missingUrlTitle: "URL অনুপস্থিত",
                missingUrlHtml: "এগিয়ে যাওয়ার জন্য অনুগ্রহ করে একটি কনটেন্ট URL লিখুন।",
                invalidUrlTitle: "অবৈধ URL",
                invalidUrlHtml: "অনুগ্রহ করে একটি বৈধ কনটেন্ট URL লিখুন।",
                providerText: "প্রদানকারী",
                itemIdText: "আইটেম আইডি",
                authorText: "লেখক",
                availableOptionsText: "উপলব্ধ ক্রয়ের বিকল্প:",
                noOptionsAvailableText: "এই মুহূর্তে এই আইটেমটির জন্য কোনও ক্রয়ের বিকল্প উপলব্ধ নেই।",
                errorFetchingDetailsTitle: "বিবরণ আনতে ত্রুটি",
                errorFetchingDefaultHtml: "এই URL এর জন্য বিবরণ পুনরুদ্ধার করা যায়নি। এটি অসমর্থিত হতে পারে বা লিঙ্কটি ভুল হতে পারে।",
                unknownErrorFetchingDetailsHtml: "বিবরণ আনার সময় একটি অজানা ত্রুটি ঘটেছে। অনুগ্রহ করে পরে আবার চেষ্টা করুন।"
            }
        };

        // Kullanıcının diline uygun çeviri setini seçiyoruz, bulunamazsa İngilizce'yi varsayılan yapıyoruz.
        const localizedStrings = allTranslations[currentUserLocale] || allTranslations['en'];

        // Global Kapsamda Fonksiyon Tanımı
        function buyItemThis(source, sourceLink) {
            Swal.fire({
                title: localizedStrings.processingPurchaseTitle,
                html: localizedStrings.processingPurchaseHtml,
                allowEscapeKey: false,
                allowOutsideClick: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.post('{{ route('api.OtherServices') }}', {
                type: 'download',
                source: source,
                url: sourceLink
            }).done((response) => {
                if (response.success && response.download) {
                    Swal.fire({
                        title: localizedStrings.purchaseSuccessfulTitle,
                        html: `
                            <p>${localizedStrings.purchaseSuccessfulHtmlLine1}</p>
                            <a class="btn btn-success btn-lg mt-2" id="downloadLinkButton" href="${response.download}" target="_blank" rel="noopener noreferrer">
                                <i class="fas fa-download me-2"></i>${localizedStrings.downloadButtonText}
                            </a>
                            <p class="mt-2"><small>${localizedStrings.downloadIfAutoFails}</small></p>
                        `,
                        icon: 'success',
                        allowOutsideClick: false
                    });
                    let iframe = document.createElement('iframe');
                    iframe.style.display = 'none';
                    iframe.src = response.download;
                    document.body.appendChild(iframe);
                    setTimeout(() => { $(iframe).remove(); }, 10000);

                } else {
                    Swal.fire({
                        title: localizedStrings.purchaseFailedTitle,
                        html: response.message || localizedStrings.purchaseFailedDefaultHtml,
                        icon: 'error'
                    });
                }
            }).fail((jqXHR) => {
                if (jqXHR.status === 401) {
                    Swal.fire({
                        title: localizedStrings.authErrorTitle,
                        html: localizedStrings.authErrorHtml,
                        icon: 'warning',
                        confirmButtonText: localizedStrings.reloadButtonText,
                        didClose: () => {
                            location.reload();
                        }
                    });
                } else {
                    Swal.fire({
                        title: localizedStrings.genericErrorTitle,
                        html: jqXHR.responseJSON && jqXHR.responseJSON.message ? jqXHR.responseJSON.message : localizedStrings.unknownErrorHtml,
                        icon: 'error'
                    });
                }
            });
        }

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#next').click(() => {
                let sourceLink = $('#url').val().trim();
                if (!sourceLink) {
                    Swal.fire({
                        title: localizedStrings.missingUrlTitle,
                        html: localizedStrings.missingUrlHtml,
                        icon: 'warning'
                    });
                    return;
                }

                try {
                    new URL(sourceLink);
                } catch (_) {
                    Swal.fire({
                        title: localizedStrings.invalidUrlTitle,
                        html: localizedStrings.invalidUrlHtml,
                        icon: 'warning'
                    });
                    return;
                }

                Swal.fire({
                    title: localizedStrings.fetchingDetailsTitle,
                    html: localizedStrings.fetchingDetailsHtml,
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showConfirmButton: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.post('{{ route('api.OtherServices') }}', {
                    type: 'ask',
                    url: sourceLink
                }).done((response) => {
                    if (response.status && response.result) {
                        let data = response.result;
                        let optionsHtml = '';

                        if (data.sources && data.sources.length > 0) {
                            optionsHtml = data.sources.map((source, index) => `
                                <button type="button" class="btn btn-primary btn-lg mb-2 w-100" onclick="buyItemThis('${source}', '${sourceLink.replace(/'/g, "\\'")}')">
                                    ${source} <span class="badge bg-light text-dark ms-2">${data.prices[index]} ₺</span>
                                </button>
                            `).join('');
                        } else {
                            optionsHtml = `<p class="text-warning">${localizedStrings.noOptionsAvailableText}</p>`;
                        }

                        Swal.fire({
                            width: '600px',
                            imageUrl: data.thumbnail,
                            imageHeight: 200,
                            imageAlt: data.title,
                            title: data.title,
                            html: `
                                <div class="my-3 text-start">
                                    <p class="mb-1"><strong>${localizedStrings.providerText}:</strong> ${data.provider || 'N/A'}</p>
                                    ${data.id ? `<p class="mb-1"><strong>${localizedStrings.itemIdText}:</strong> ${data.id}</p>` : ''}
                                    ${data.author ? `<p class="mb-1"><strong>${localizedStrings.authorText}:</strong> ${data.author}</p>` : ''}
                                </div>
                                <hr>
                                <h6 class="mt-3 mb-3 fw-bold">${localizedStrings.availableOptionsText}</h6>
                                <div class="d-grid gap-2 col-10 mx-auto">
                                    ${optionsHtml}
                                </div>
                            `,
                            showCloseButton: true,
                            showConfirmButton: false,
                            focusConfirm: false,
                        });

                    } else {
                        let errorMessage = response.message === 'nolimit' ? localizedStrings.nolimitMessage : response.message;
                        if (!errorMessage || typeof errorMessage === 'undefined' || errorMessage === "undefined") {
                            errorMessage = localizedStrings.errorFetchingDefaultHtml;
                        }
                        Swal.fire({
                            title: localizedStrings.errorFetchingDetailsTitle,
                            html: errorMessage,
                            icon: 'warning'
                        });
                    }

                }).fail((jqXHR) => {
                    if (jqXHR.status === 401){
                        Swal.fire({
                            title: localizedStrings.authErrorTitle,
                            html: localizedStrings.authErrorHtml,
                            icon: 'warning',
                            confirmButtonText: localizedStrings.reloadButtonText,
                            didClose: () => {
                                location.reload();
                            }
                        });
                    } else {
                        let errorMsg = localizedStrings.unknownErrorFetchingDetailsHtml;
                        if (jqXHR.responseJSON && jqXHR.responseJSON.message) {
                            errorMsg = jqXHR.responseJSON.message;
                        }
                        Swal.fire({
                            title: localizedStrings.genericErrorTitle,
                            html: errorMsg,
                            icon: 'error'
                        });
                    }
                });
            });
        });
    </script>
@endsection