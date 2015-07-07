(ns notejam.entities
  (:require [compojure.core :refer :all]
            [environ.core :refer [env]])
  (:use [korma.db]
        [korma.core :only [select* defentity entity-fields as-sql exec insert values where]]))

(defdb database (sqlite3 {:db (env :database-file)}))

(derive ::admin ::user)

(defentity users
  (entity-fields :id :email :password))

(defentity pads
  (entity-fields :id :user_id :name))

(defn find-user [username]
  (-> (select* users)
      (where {:email username})
      (exec)
      (first)))

(defn create-user [user-data]
  (insert users (values user-data)))

(defn get-user-pads [user]
  (-> (select* pads)
      (where {:user_id (:id user)})
      (exec)))
