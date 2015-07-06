(ns notejam.validators
  (:require [compojure.core :refer :all]
            [bouncer.core :as b]
            [bouncer.validators :as v]))

; @TODO add "matches field" and "unique" validators
(defn validate-user [user]
  (b/validate user
    :email [v/required v/email]
    :password v/required))
