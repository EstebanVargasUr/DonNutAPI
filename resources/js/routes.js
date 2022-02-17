const Home = () => import('./components/Home.vue')
const Login = () => import('./components/auth/Login.vue')
const NotFound = () => import('./components/NotFound.vue')

//importamos los componentes para el Producto
const Mostrar = () => import('./components/producto/Mostrar.vue')
const Crear = () => import('./components/producto/Crear.vue')
const Editar = () => import('./components/producto/Editar.vue')

export const routes = [
    {
        name: 'login',
        path: '/login',
        component: Login
    },
    {
        name: 'home',
        path: '/',
        component: Home,
        beforeEnter: (to, from, next) => {
            if(!localStorage.getItem('token')) next({ name: 'login' })
            else next()
        }
    },
    {
        name: 'mostrarProductos',
        path: '/productos',
        component: Mostrar,
        beforeEnter: (to, from, next) => {
            if(!localStorage.getItem('token')) next({ name: 'login' })
            else next()
        }
    },
    {
        name: 'crearProducto',
        path: '/crear',
        component: Crear,
        beforeEnter: (to, from, next) => {
            if(!localStorage.getItem('token')) next({ name: 'login' })
            else next()
        }
    },
    {
        name: 'editarProducto',
        path: '/editar/:id',
        component: Editar,
        beforeEnter: (to, from, next) => {
            if(!localStorage.getItem('token')) next({ name: 'login' })
            else next()
        }
    },
    { 
        name: 'NotFound',
        path: '/:pathMatch(.*)*',  
        component: NotFound 
    }
]