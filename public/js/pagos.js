new Vue({
    el:'#placetopay',
    data:{
        persona:{
            tipo_doc:'CC',
            documento:'',
            nombres:'',
            apellidos:'',
            email:'',
            telefono:'',
            direccion:{
                pais:'Colombia',
                ciudad:'Medellin',
                direccion:''
            },
            compra:{
                descripcion:'Preventa',
                total: '1900'
            }
        }
    },
    mounted(){
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    },
    methods:{
        enviar(){
            
            $.ajax({
                type: "POST",
                url: "/compra",
                data: this.persona,
                dataType: "JSON",
                success: function (response) {
                    console.log(response);
                    if (response.resp) {
                        window.location.href = response.placetopay.processUrl;  
                    }
                    
                }
            });

        }
    },
})


// $('#enviar').click(function (e) { 
//     e.preventDefault();
    
// });