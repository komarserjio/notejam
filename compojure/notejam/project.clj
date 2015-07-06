(defproject notejam "0.1.0-SNAPSHOT"
  :description "Notejam profject"
  :url "http://example.com/FIXME"
  :min-lein-version "2.0.0"
  :dependencies [[org.clojure/clojure "1.6.0"]
                 [compojure "1.3.1"]
                 [hiccup "1.0.5"]
                 [korma "0.4.0"]
                 [environ "1.0.0"]
                 [org.xerial/sqlite-jdbc "3.7.15-M1"]
                 [bouncer "0.3.3"]
                 [kerodon "0.5.0"]
                 [com.cemerick/friend "0.2.1"]
                 [ring/ring-defaults "0.1.2"]]
  :plugins [[lein-ring "0.8.13"]
            [lein-environ "1.0.0"]]
  :ring {:handler notejam.handler/app}
  :profiles
  {:dev {:dependencies [[javax.servlet/servlet-api "2.5"]
                        [kerodon "0.5.0"]
                        [ring-mock "0.1.5"]]}})
