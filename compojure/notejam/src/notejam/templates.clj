(ns notejam.templates
  (:require [compojure.core :refer :all]
            [clojure.string :refer [join]]
            [hiccup.form :as f]
            [cemerick.friend :as friend]
            [hiccup.core :refer [html]])
  (:use [notejam.entities :only [get-user-pads]]))

(defn- render-flash-messages [request]
  "Render flash messages"
  (if-let [messages (:flash request)]
    (html [:div {:class "alert-area"}
            (for [[classname, message] messages]
              [:div {:class (str "alert alert-" (name classname))} message])])))

(defn- render-field-errors [field validation]
  (if-not (nil? validation)
    (let [errors (first validation)]
      (if (contains? errors field)
        (html [:ul {:class "errorlist"}
                (for [error (errors field)]
                  [:li error])])))))

(defn- render-pad-menu [user]
  [:div {:class "three columns"}
    [:h4 {:id "logo"} "My pads"]
    [:nav
      (let [pads (get-user-pads user)]
        (if (not (empty? pads))
          [:ul
            (for [pad pads]
              [:li
                [:a {:href "test"} (:name pad)]])]
          [:p "No pads yet"]))
      [:hr]
      [:a {:href "#"} "Create pad"]]])

(defn base-layout
  "Base layout"
  [{:keys [size title content request]:or {size "thirteen"}}]
  [:html
    [:head
      [:title title]
      [:link {:rel "stylesheet" :href "http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/base.min.css"}]
      [:link {:rel "stylesheet" :href "http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/skeleton.min.css"}]
      [:link {:rel "stylesheet" :href "http://cdnjs.cloudflare.com/ajax/libs/skeleton/1.2/layout.min.css"}]
      [:link {:rel "stylesheet" :href "/css/style.css"}]
    [:body
      [:div {:class "container"}
        [:div {:class "sixteen columns"}
          [:div {:class "sign-in-out-block"}
            (if-let [current-user (friend/current-authentication request)]
              (str
                (str (:email current-user) ": ")
                (html [:a {:href "/settings"} "Account settings"])
                "&nbsp;&nbsp;&nbsp;"
                (html [:a {:href "/signout"} "Sign out"]))
              (str
                (html [:a {:href "/signup"} "Sign up"])
                "&nbsp;&nbsp;&nbsp;"
                (html [:a {:href "/signin"} "Sign in"])))
            ]]
        [:div {:class "sixteen columns"}
          [:h1 {:class "bold-header"}
            [:a {:href "#" :class "header"} (str "note" (html [:span {:class "jam"} "jam:"]))]
            [:span {:class "page-title"} (str " " title)]]]
        (if (= size "thirteen")
          (html (render-pad-menu (friend/current-authentication request))))
        [:div {:class  (str size " columns content-area")}
          (render-flash-messages request)
          content]
        [:hr {:class "footer"}]
        [:div {:class "footer"}
          [:div (str "Notejam: " (html [:strong "Compojure"]) " application")]
          [:div
            (join
              ", "
              (list (html [:a {:href "https://github.com/komarserjio/notejam"} "Github"])
                    (html [:a {:href "https://twitter.com/komarserjio"} "Twitter"])
                    (str "created by " (html [:a {:href "https://github.com/komarserjio/"} "Serhii Komar"]))))]]]]]])


(defn user-layout [params]
  (base-layout (assoc params :size "sixteen")))

(defn user-signup [& {:keys [validation] :or {validation nil}}]
  (f/form-to {:class "offset-by-six sign-in"} [:post ""]
    (f/label :email "Email")
    (f/text-field :email)
    (render-field-errors :email validation)

    (f/label :password "Password")
    (f/password-field :password)
    (render-field-errors :password validation)

    (f/label "repeat_password" "Repeat password")
    (f/password-field "repeat_password")

    (f/submit-button "Sign Up")))

(defn user-signin []
  (f/form-to {:class "offset-by-six sign-in"} [:post ""]
    (f/label :username "Email")
    (f/text-field :username)

    (f/label :password "Password")
    (f/password-field :password)

    (f/submit-button "Sign In")))

(defn pad-form []
  (f/form-to {:class "pad"} [:post ""]
    (f/label :name "Name")
    (f/text-field :name)

    (f/submit-button "Save")))
