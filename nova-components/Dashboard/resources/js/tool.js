Nova.booting((Vue, router, store) => {
    router.addRoutes([
        {
            name: 'dashboard',
            path: '/dashboard',
            component: require('./components/Tool'),
        },
    ])
})
