const Ziggy = {"url":"http:\/\/labelimg.th","port":null,"defaults":{},"routes":{"debugbar.openhandler":{"uri":"_debugbar\/open","methods":["GET","HEAD"]},"debugbar.clockwork":{"uri":"_debugbar\/clockwork\/{id}","methods":["GET","HEAD"],"parameters":["id"]},"debugbar.assets.css":{"uri":"_debugbar\/assets\/stylesheets","methods":["GET","HEAD"]},"debugbar.assets.js":{"uri":"_debugbar\/assets\/javascript","methods":["GET","HEAD"]},"debugbar.cache.delete":{"uri":"_debugbar\/cache\/{key}\/{tags?}","methods":["DELETE"],"parameters":["key","tags"]},"login":{"uri":"login","methods":["GET","HEAD"]},"logout":{"uri":"logout","methods":["POST"]},"password.request":{"uri":"forgot-password","methods":["GET","HEAD"]},"password.reset":{"uri":"reset-password\/{token}","methods":["GET","HEAD"],"parameters":["token"]},"password.email":{"uri":"forgot-password","methods":["POST"]},"password.update":{"uri":"reset-password","methods":["POST"]},"register":{"uri":"register","methods":["GET","HEAD"]},"user-profile-information.update":{"uri":"user\/profile-information","methods":["PUT"]},"user-password.update":{"uri":"user\/password","methods":["PUT"]},"password.confirmation":{"uri":"user\/confirmed-password-status","methods":["GET","HEAD"]},"password.confirm":{"uri":"user\/confirm-password","methods":["POST"]},"two-factor.login":{"uri":"two-factor-challenge","methods":["GET","HEAD"]},"two-factor.enable":{"uri":"user\/two-factor-authentication","methods":["POST"]},"two-factor.confirm":{"uri":"user\/confirmed-two-factor-authentication","methods":["POST"]},"two-factor.disable":{"uri":"user\/two-factor-authentication","methods":["DELETE"]},"two-factor.qr-code":{"uri":"user\/two-factor-qr-code","methods":["GET","HEAD"]},"two-factor.secret-key":{"uri":"user\/two-factor-secret-key","methods":["GET","HEAD"]},"two-factor.recovery-codes":{"uri":"user\/two-factor-recovery-codes","methods":["GET","HEAD"]},"profile.show":{"uri":"user\/profile","methods":["GET","HEAD"]},"other-browser-sessions.destroy":{"uri":"user\/other-browser-sessions","methods":["DELETE"]},"current-user-photo.destroy":{"uri":"user\/profile-photo","methods":["DELETE"]},"current-user.destroy":{"uri":"user","methods":["DELETE"]},"sanctum.csrf-cookie":{"uri":"sanctum\/csrf-cookie","methods":["GET","HEAD"]},"ignition.healthCheck":{"uri":"_ignition\/health-check","methods":["GET","HEAD"]},"ignition.executeSolution":{"uri":"_ignition\/execute-solution","methods":["POST"]},"ignition.updateConfig":{"uri":"_ignition\/update-config","methods":["POST"]},"dashboard":{"uri":"\/","methods":["GET","HEAD"]},"user.dashboard":{"uri":"home","methods":["GET","HEAD"]},"user.project.index":{"uri":"project","methods":["GET","HEAD"]},"user.project.store":{"uri":"project\/add","methods":["POST"]},"user.project.update":{"uri":"project\/edit\/{id}","methods":["PUT"],"parameters":["id"]},"user.project.destroy":{"uri":"project\/delete\/{id}","methods":["DELETE"],"parameters":["id"]},"user.project.detail":{"uri":"project\/{project_id}","methods":["GET","HEAD"],"parameters":["project_id"]},"user.image.index":{"uri":"image","methods":["GET","HEAD"]},"user.image.upload":{"uri":"image\/add\/{project_id}","methods":["POST"],"parameters":["project_id"]},"user.image.update":{"uri":"image\/edit\/{id}","methods":["PUT"],"parameters":["id"]},"user.image.destroy":{"uri":"image\/delete\/{id}","methods":["DELETE"],"parameters":["id"]},"user.image.detail":{"uri":"image\/{image_id}","methods":["GET","HEAD"],"parameters":["image_id"]},"admin.homepage":{"uri":"admin","methods":["GET","HEAD"]},"admin.user.index":{"uri":"admin\/user-manager","methods":["GET","HEAD"]},"admin.label.index":{"uri":"admin\/label-manager\/{label_type}","methods":["GET","HEAD"],"parameters":["label_type"]},"admin.label.store":{"uri":"admin\/label-manager\/add","methods":["POST"]},"admin.label.update":{"uri":"admin\/label-manager\/edit\/{id}","methods":["PUT"],"parameters":["id"]},"admin.label.destroy":{"uri":"admin\/label-manager\/delete\/{id}","methods":["DELETE"],"parameters":["id"]}}};

if (typeof window !== 'undefined' && typeof window.Ziggy !== 'undefined') {
    Object.assign(Ziggy.routes, window.Ziggy.routes);
}

export { Ziggy };
