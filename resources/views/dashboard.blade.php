<x-app-layout>
    <div class="bg-crema-suave">
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-marron-chocolate bg-oro-antiguo leading-tight">
                Dashboard
            </h2>
        </x-slot>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-beige-crema border-b border-gray-200">
                        <h1 class="bg-marron-chocolate text-beige-tostado text-2xl font-bold mb-4">
                            Resumen de tus productos
                        </h1>
                        <!-- canvas para el gráfico --> 
                        <canvas id="productosChart" width="400" height="200"></canvas>   
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--script para renderizar el gráfico -->
    <script>
        //Obtener datos desde Blade con @@json (para convertir el array de php($nombres, $cantidades) en objeto @json de javascript(nombres, cantidades))
        const nombres = @json($nombres);
        const cantidades = @json($cantidades);
        //Configuración del gráfico
        const ctx = document.getElementById('productosChart').getContext('2d');
        const productosChart = new Chart(ctx, {     //Generar un nuevo gráfico
            type: 'bar',  //Tipo de gráfico de barras
            data: {
                labels: nombres,    //Etiquetas en el eje X (nombres de productos)
                datasets: [{
                    label: 'Cantidad de productos',
                    data: cantidades, //Datos (cantidades de productos)
                    backgroundColor: 'rgb(210, 180, 140)',
                    borderColor: 'rgb(184,134,11)',
                    borderWidth: 1  //Anchura del borde
                }]
            },
            options: {
                scales:{
                    //Eje Y
                    y: {
                        beginAtZero: true   //El eje Y empieza desde cero
                    }
                }
            }
        });
    </script>
</x-app-layout>
