(ns notejam.utils
  (:require [compojure.core :refer :all]
            [cemerick.friend :as friend]
            [ring.util.response]))

(defn render-response [body & mixins]
  (merge {:status 200 :body body :headers {"Content-Type" "text/html"}}
         mixins))

(defn redirect-response [location mixins]
  (merge (ring.util.response/redirect location) mixins))

(defn unauthorized!
  "Throws the proper unauthorized! slingshot error if authentication
  fails. This error is picked up upstream by friend's middleware."
  [handler req]
  (friend/throw-unauthorized (friend/identity req)
                             {::wrapped-handler handler}))

(defn wrap-authenticated
  "Takes a handler and wraps it with a check that the current user is
  authenticated."
  [handler]
  (fn [req]
    (if (friend/identity req)
      (handler req)
      (unauthorized! handler req))))

