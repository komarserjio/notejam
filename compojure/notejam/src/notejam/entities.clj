(ns notejam.entities
  (:require [compojure.core :refer :all]
            [environ.core :refer [env]])
  (:use [korma.db]
        [korma.core :only [select* defentity entity-fields as-sql exec insert values where]]))

(defdb database (sqlite3 {:db (env :database-file)}))

(derive ::admin ::user)

(defentity users
  (entity-fields :id :email :password))

(defn find-user [username]
  (-> (select* users)
      (where {:email username})
      (exec)
      (first)))

(defn create-user [user-data]
  (insert users (values user-data)))
