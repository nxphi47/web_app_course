import pandas as pd
import numpy as np


path = "Database.csv"
menu_path = "db.txt"

df = pd.read_csv(path)
df = df.replace(np.nan, '', regex=True)

dict_list = df.to_dict('records')

template = "INSERT INTO menu (title, type, unit, price, promoted_price, note, desc, ingredients, thumbnail, images) VALUES ('{title}', '{type}', '{unit}', {price}, {promoted_price}, '{note}', '{desc}', '{ingredients}', '{thumbnail}', '{images}')"

templates = [template.format(**d) for i, d in enumerate(dict_list)]

joint_temp = ";".join(templates)



