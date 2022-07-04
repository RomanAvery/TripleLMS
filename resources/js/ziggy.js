const Ziggy = {"url":"http:\/\/localhost:8000","port":8000,"defaults":{},"routes":{"nova-settings.get":{"uri":"nova-vendor\/nova-settings\/settings","methods":["GET","HEAD"]},"nova-settings.save":{"uri":"nova-vendor\/nova-settings\/settings","methods":["POST"]},"dusk.login":{"uri":"_dusk\/login\/{userId}\/{guard?}","methods":["GET","HEAD"]},"dusk.logout":{"uri":"_dusk\/logout\/{guard?}","methods":["GET","HEAD"]},"dusk.user":{"uri":"_dusk\/user\/{guard?}","methods":["GET","HEAD"]},"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"password.request":{"uri":"forgot-password","methods":["GET","HEAD"]},"password.reset":{"uri":"reset-password\/{token}","methods":["GET","HEAD"]},"password.email":{"uri":"forgot-password","methods":["POST"]},"password.update":{"uri":"reset-password","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"user-profile-information.update":{"uri":"user\/profile-information","methods":["PUT"]},"user-password.update":{"uri":"user\/password","methods":["PUT"]},"password.confirmation":{"uri":"user\/confirmed-password-status","methods":["GET","HEAD"]},"password.confirm":{"uri":"user\/confirm-password","methods":["POST"]},"two-factor.login":{"uri":"two-factor-challenge","methods":["GET","HEAD"]},"two-factor.enable":{"uri":"user\/two-factor-authentication","methods":["POST"]},"two-factor.confirm":{"uri":"user\/confirmed-two-factor-authentication","methods":["POST"]},"two-factor.disable":{"uri":"user\/two-factor-authentication","methods":["DELETE"]},"two-factor.qr-code":{"uri":"user\/two-factor-qr-code","methods":["GET","HEAD"]},"two-factor.secret-key":{"uri":"user\/two-factor-secret-key","methods":["GET","HEAD"]},"two-factor.recovery-codes":{"uri":"user\/two-factor-recovery-codes","methods":["GET","HEAD"]},"profile.show":{"uri":"user\/profile","methods":["GET","HEAD"]},"other-browser-sessions.destroy":{"uri":"user\/other-browser-sessions","methods":["DELETE"]},"current-user-photo.destroy":{"uri":"user\/profile-photo","methods":["DELETE"]},"current-user.destroy":{"uri":"user","methods":["DELETE"]},"nova.api.":{"uri":"nova-api\/{resource}\/{resourceId}\/attach-morphed\/{relatedResource}","methods":["POST"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"nova.pages.login":{"uri":"admin\/login","methods":["GET","HEAD"]},"nova.login":{"uri":"admin\/login","methods":["POST"]},"nova.logout":{"uri":"admin\/logout","methods":["POST"]},"nova.pages.password.email":{"uri":"admin\/password\/reset","methods":["GET","HEAD"]},"nova.password.email":{"uri":"admin\/password\/email","methods":["POST"]},"nova.pages.password.reset":{"uri":"admin\/password\/reset\/{token}","methods":["GET","HEAD"]},"nova.password.reset":{"uri":"admin\/password\/reset","methods":["POST"]},"nova.pages.403":{"uri":"admin\/403","methods":["GET","HEAD"]},"nova.pages.404":{"uri":"admin\/404","methods":["GET","HEAD"]},"nova.pages.home":{"uri":"admin","methods":["GET","HEAD"]},"nova.pages.dashboard":{"uri":"admin\/dashboard","methods":["GET","HEAD","POST","PUT","PATCH","DELETE","OPTIONS"]},"nova.pages.dashboard.custom":{"uri":"admin\/dashboards\/{name}","methods":["GET","HEAD"]},"nova.pages.index":{"uri":"admin\/resources\/{resource}","methods":["GET","HEAD"]},"nova.pages.create":{"uri":"admin\/resources\/{resource}\/new","methods":["GET","HEAD"]},"nova.pages.detail":{"uri":"admin\/resources\/{resource}\/{resourceId}","methods":["GET","HEAD"]},"nova.pages.edit":{"uri":"admin\/resources\/{resource}\/{resourceId}\/edit","methods":["GET","HEAD"]},"nova.pages.replicate":{"uri":"admin\/resources\/{resource}\/{resourceId}\/replicate","methods":["GET","HEAD"]},"nova.pages.lens":{"uri":"admin\/resources\/{resource}\/lens\/{lens}","methods":["GET","HEAD"]},"nova.pages.attach":{"uri":"admin\/resources\/{resource}\/{resourceId}\/attach\/{relatedResource}","methods":["GET","HEAD"]},"nova.pages.edit-attached":{"uri":"admin\/resources\/{resource}\/{resourceId}\/edit-attached\/{relatedResource}\/{relatedResourceId}","methods":["GET","HEAD"]},"google.login":{"uri":"auth\/google","methods":["GET","HEAD"]},"google.callback":{"uri":"callback\/google","methods":["GET","HEAD"]},"microsoft.login":{"uri":"auth\/microsoft","methods":["GET","HEAD"]},"microsoft.callback":{"uri":"callback\/microsoft","methods":["GET","HEAD"]},"index":{"uri":"\/","methods":["GET","HEAD"]},"logo":{"uri":"logo","methods":["GET","HEAD"]},"dashboard":{"uri":"dashboard","methods":["GET","HEAD"]},"courses.index":{"uri":"courses\/{id}","methods":["GET","HEAD"]},"courses.topic":{"uri":"courses\/topic\/{id}\/{activity_id?}","methods":["GET","HEAD"]},"comments.activity":{"uri":"comments\/activity\/{id}\/{type}","methods":["GET","HEAD"]},"comments.answers":{"uri":"comments\/answers\/{id}","methods":["GET","HEAD"]},"nav.topic.activity":{"uri":"nav\/topic\/activity\/{id}","methods":["GET","HEAD"]},"access-code":{"uri":"access-code","methods":["POST"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
