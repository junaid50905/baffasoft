const Ziggy = {"url":"http:\/\/localhost\/baffasoft","port":null,"defaults":{},"routes":{"member.login":{"uri":"login","methods":["GET","HEAD"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
