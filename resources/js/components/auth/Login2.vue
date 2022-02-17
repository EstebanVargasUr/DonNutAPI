<style>
     body{
        background-color: #ffe259;
        background: linear-gradient(to right, #ffa751, #ffe259);
    } 
       .bg{
           background-image: url("https://i2.wp.com/turevistadecocina.com/wp-content/uploads/2018/04/IMG_4471.jpg");
           background-repeat: no-repeat;
       }
   </style>
   <template>
       <div class="container bg-primary rounded shadow" style="margin-top:20vh;">
           <div class="row align-items-stretch">
               <div class="col bg d-none d-lg-block col-lg-8 col-md-6 col-sm-4 col-2 rounded">

               </div>
               <div class="col bg-white p-5 rounded-end">
                   <div class="text-left">
                       <img src="https://cdn.discordapp.com/attachments/800098498699591680/906642215110078545/unknown.png"
                       width="100" alt="">
                   </div>

                   <h2 class="fw-bold text-left py-5">Bienvenido</h2>

                   <form action="#">
                       <div class="mb-4">
                           <label for="email" class="form-label">Correo electrónico</label>
                           <input type="email" class="form-control" name="email">
                       </div>
                       <div class="mb-4">
                           <label for="password" class="form-label">Password</label>
                           <input type="password" class="form-control" name="password">
                       </div>
                       <div class="mb-4 form-check">
                           <input type="checkbox" name="connected" class="form-check-input">
                           <label for="connected" class="form-check-label">Mantener conectado</label>
                       </div>
                       <div class="d-grid">
                           <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                       </div>
                   </form>
               </div>
           </div>
       </div>
    
</template>