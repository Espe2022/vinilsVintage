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
                        <!-- <h1 class="bg-marron-chocolate text-beige-tostado text-2xl font-bold mb-4">
                            Resumen de tus productos
                        </h1> -->
                        <!-- canvas para el gráfico --> 
                        <!-- <canvas id="productosChart" width="400" height="200"></canvas>    -->

                        <h1 class="bg-marron-chocolate text-beige-tostado text-5xl text-center font-bold mb-8">
                            <!-- mb-8 indica el margen entre el h1 y la tabla -->
                        Histórico de tus productos
                        </h1>

                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-oro-antiguo text-s font-medium">
                                <tr>
                                    <th class="px-4 py-2 text-left text-marron-chocolate uppercase tracking-wider">
                                        Producto (fecha)
                                    </th>
                                    <th class="px-4 py-2 text-left text-marron-chocolate uppercase tracking-wider">
                                        Cantidad
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="bg-amber-200 divide-y divide-gray-200">
                                @foreach($productosCombinados as $producto)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-marron-chocolate">
                                            {{ $producto['nombre'] }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-marron-chocolate">
                                            {{ $producto['cantidad'] }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- script para renderizar el gráfico
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
                    label: 'Cantidad',
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
    </script> -->

    

<!-- Incluir Pie de página -->
@include('pie.footer')

</x-app-layout>
