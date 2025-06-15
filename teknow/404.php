<!DOCTYPE html>
<html lang="es">
<head>
    <?php 
    // Se elimina el header HTTP 404 para que sea un error genérico
    include 'includes/layout/head.php'; 
    ?>
</head>

<body>
    <?php include 'includes/partials/visual_effects.php'; ?>
    
    <!-- Contenedor principal -->
    <div id="app">
        <?php include 'includes/layout/header.php'; ?>

        <!-- Contenido de la página de error genérico -->
        <main class="container mx-auto px-4 py-8">
            <div class="error-container p-8 md:p-16 rounded-lg text-center my-12">
                <h2 class="text-6xl md:text-8xl font-bold mb-6 error-glitch neon-text-red">ERROR</h2>
                <h3 class="text-2xl md:text-3xl font-bold mb-6">ALGO SALIÓ MAL</h3>
                <p class="text-lg mb-8">No pudimos procesar tu solicitud. Por favor, intenta nuevamente más tarde.</p>
                <div class="flex justify-center">
                    <a href="/teknow/" class="cyber-btn">
                        <i class="fas fa-home mr-2"></i> Volver al inicio
                    </a>
                </div>

                <div class="mt-12">
                    <div class="w-full h-1 bg-[#ff0033]/20 relative mb-8">
                        <div class="absolute top-0 left-0 h-full bg-[#ff0033] animate-pulse" style="width: 30%;"></div>
                    </div>
                </div>
            </div>
        </main>

        <?php include 'includes/layout/footer.php'; ?>
    </div>

    <script>
        const app = {
            currentPage: 'home',
            currentCategory: null,

            init() {
                this.setupEventListeners();
                this.setupFormValidation();
            },

            setupEventListeners() {
                const search = document.getElementById('searchInput');
                if (search) {
                    search.addEventListener('input', this.handleSearch);
                }
            },

            showPage(pageName, category = null) {
                document.querySelectorAll('.page-content').forEach(page => {
                    page.classList.add('hidden');
                });

                const pageElement = document.getElementById(pageName);
                if (pageElement) {
                    pageElement.classList.remove('hidden');
                    this.currentPage = pageName;
                    this.currentCategory = category;
                } else {
                    document.getElementById('error404').classList.remove('hidden');
                    this.currentPage = 'error404';
                }

                window.scrollTo(0, 0);
            }
        };

        document.addEventListener('DOMContentLoaded', () => {
            app.init();
        });
    </script>
</body>
</html>
