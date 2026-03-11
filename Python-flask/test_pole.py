import time
import random
from flask import Flask, jsonify

app = Flask(__name__)

@app.route('/pole')
def test_pole():
    iterace = 100
    casy = []
    velikost_pole = 100000
    
    for _ in range(iterace):
        # 1. Vygenerování pole s náhodnými čísly (příprava dat - neměříme)
        pole = [random.randint(1, 1000000) for _ in range(velikost_pole)]
        
        # 2. Start stopek - Měříme POUZE samotné třídění
        start_time = time.time()
        
        # Nativní funkce Pythonu pro seřazení
        pole.sort()
        
        end_time = time.time()
        # 3. Stop stopek
        
        casy.append((end_time - start_time) * 1000)
        
    prumerny_cas = sum(casy) / len(casy)
    
    return jsonify({
        'jazyk': 'Python Flask',
        'test': f'Třídění pole ({velikost_pole} prvků)',
        'pocet_iteraci': iterace,
        'prumerny_cas_ms': round(prumerny_cas, 2)
    })

if __name__ == '__main__':
    app.run(port=5000)