(ns notejam.handler
  (:require [compojure.core :refer :all]
            [compojure.route :as route]
            [cemerick.friend :as friend]
            (cemerick.friend [workflows :as workflows]
                             [credentials :as creds])
            [hiccup.core :refer [html]]
            [ring.util.response]
            [ring.middleware.defaults :refer [wrap-defaults site-defaults]])
  (:use [notejam.templates :only [user-layout user-signup user-signin]]
        [notejam.validators :only [validate-user]]
        [notejam.utils]
        [notejam.entities :only [find-user create-user]]))


(defroutes private-routes
  (GET "/settings" []
    (fn [req]
      "Settings"))
  (GET "/pads/create" req
       "Create a pad page")
  (POST "/pads/create" req
       "Pad is created"))

; Routes
(defroutes app-routes
  (GET "/" [] "Index")
  (GET "/signup" req
       (html (user-layout {:request req
                           :title "Sign up"
                           :menu [:p "this is menu"]
                           :content (user-signup)})))
  (POST "/signup" []
        (fn [req]
          (let [validation (validate-user (:params req))
                user-data (second validation)]
            (if (nil? (first validation))
              (do
                (create-user {:email (:email user-data)
                              :password (creds/hash-bcrypt (:password user-data))})
                (redirect-response "/signin"
                                   {:flash {:success "Now you can sign in"}}))
              (render-response
                (html (user-layout {:request req
                                    :title "Sign up"
                                    :content (user-signup :validation validation)})))))))

  (GET "/signin" []
       (fn [req]
         (if (contains? (:params req) :login_failed)
            (redirect-response "/signin"
                               {:flash {:error "Wrong credentials"}})
            (render-response (html (user-layout {:request req
                                                 :title "Sign in"
                                                 :content (user-signin)}))))))
  (wrap-routes private-routes wrap-authenticated)
  (route/not-found "Not Found"))

(def app
  (wrap-defaults (friend/authenticate app-routes
                                      {:unauthorized-handler (fn[] "not allowed")
                                       :credential-fn #(creds/bcrypt-credential-fn find-user %)
                                       :workflows [(workflows/interactive-form)]
                                       :login-uri "/signin"})
                 (assoc site-defaults :security false)))
