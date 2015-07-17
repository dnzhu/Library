(function() {
	var t;
	var i = 0xdeadbeefcafe;
	var r = (i & 16777215) == 15715070;

	function s(t, i, r) {
		if (t != null) if ("number" == typeof t) this.fromNumber(t, i, r);
		else if (i == null && "string" != typeof t) this.fromString(t, 256);
		else this.fromString(t, i)
	}
	function e() {
		return new s(null)
	}
	function o(t, i, r, s, e, o) {
		while (--o >= 0) {
			var n = i * this[t++] + r[s] + e;
			e = Math.floor(n / 67108864);
			r[s++] = n & 67108863
		}
		return e
	}
	function n(t, i, r, s, e, o) {
		var n = i & 32767,
			h = i >> 15;
		while (--o >= 0) {
			var f = this[t] & 32767;
			var a = this[t++] >> 15;
			var u = h * f + a * n;
			f = n * f + ((u & 32767) << 15) + r[s] + (e & 1073741823);
			e = (f >>> 30) + (u >>> 15) + h * a + (e >>> 30);
			r[s++] = f & 1073741823
		}
		return e
	}
	function h(t, i, r, s, e, o) {
		var n = i & 16383,
			h = i >> 14;
		while (--o >= 0) {
			var f = this[t] & 16383;
			var a = this[t++] >> 14;
			var u = h * f + a * n;
			f = n * f + ((u & 16383) << 14) + r[s] + e;
			e = (f >> 28) + (u >> 14) + h * a;
			r[s++] = f & 268435455
		}
		return e
	}
	if (r && navigator.appName == "Microsoft Internet Explorer") {
		s.prototype.am = n;
		t = 30
	} else if (r && navigator.appName != "Netscape") {
		s.prototype.am = o;
		t = 26
	} else {
		s.prototype.am = h;
		t = 28
	}
	s.prototype.DB = t;
	s.prototype.DM = (1 << t) - 1;
	s.prototype.DV = 1 << t;
	var f = 52;
	s.prototype.FV = Math.pow(2, f);
	s.prototype.F1 = f - t;
	s.prototype.F2 = 2 * t - f;
	var a = "0123456789abcdefghijklmnopqrstuvwxyz";
	var u = new Array;
	var l, p;
	l = "0".charCodeAt(0);
	for (p = 0; p <= 9; ++p) u[l++] = p;
	l = "a".charCodeAt(0);
	for (p = 10; p < 36; ++p) u[l++] = p;
	l = "A".charCodeAt(0);
	for (p = 10; p < 36; ++p) u[l++] = p;

	function c(t) {
		return a.charAt(t)
	}
	function m(t, i) {
		var r = u[t.charCodeAt(i)];
		return r == null ? -1 : r
	}
	function y(t) {
		for (var i = this.t - 1; i >= 0; --i) t[i] = this[i];
		t.t = this.t;
		t.s = this.s
	}
	function w(t) {
		this.t = 1;
		this.s = t < 0 ? -1 : 0;
		if (t > 0) this[0] = t;
		else if (t < -1) this[0] = t + this.DV;
		else this.t = 0
	}
	function T(t) {
		var i = e();
		i.fromInt(t);
		return i
	}
	function d(t, i) {
		var r;
		if (i == 16) r = 4;
		else if (i == 8) r = 3;
		else if (i == 256) r = 8;
		else if (i == 2) r = 1;
		else if (i == 32) r = 5;
		else if (i == 4) r = 2;
		else {
			this.fromRadix(t, i);
			return
		}
		this.t = 0;
		this.s = 0;
		var e = t.length,
			o = false,
			n = 0;
		while (--e >= 0) {
			var h = r == 8 ? t[e] & 255 : m(t, e);
			if (h < 0) {
				if (t.charAt(e) == "-") o = true;
				continue
			}
			o = false;
			if (n == 0) this[this.t++] = h;
			else if (n + r > this.DB) {
				this[this.t - 1] |= (h & (1 << this.DB - n) - 1) << n;
				this[this.t++] = h >> this.DB - n
			} else this[this.t - 1] |= h << n;
			n += r;
			if (n >= this.DB) n -= this.DB
		}
		if (r == 8 && (t[0] & 128) != 0) {
			this.s = -1;
			if (n > 0) this[this.t - 1] |= (1 << this.DB - n) - 1 << n
		}
		this.clamp();
		if (o) s.ZERO.subTo(this, this)
	}
	function g() {
		var t = this.s & this.DM;
		while (this.t > 0 && this[this.t - 1] == t)--this.t
	}
	function D(t) {
		if (this.s < 0) return "-" + this.negate().toString(t);
		var i;
		if (t == 16) i = 4;
		else if (t == 8) i = 3;
		else if (t == 2) i = 1;
		else if (t == 32) i = 5;
		else if (t == 4) i = 2;
		else return this.toRadix(t);
		var r = (1 << i) - 1,
			s, e = false,
			o = "",
			n = this.t;
		var h = this.DB - n * this.DB % i;
		if (n-- > 0) {
			if (h < this.DB && (s = this[n] >> h) > 0) {
				e = true;
				o = c(s)
			}
			while (n >= 0) {
				if (h < i) {
					s = (this[n] & (1 << h) - 1) << i - h;
					s |= this[--n] >> (h += this.DB - i)
				} else {
					s = this[n] >> (h -= i) & r;
					if (h <= 0) {
						h += this.DB;
						--n
					}
				}
				if (s > 0) e = true;
				if (e) o += c(s)
			}
		}
		return e ? o : "0"
	}
	function b() {
		var t = e();
		s.ZERO.subTo(this, t);
		return t
	}
	function S() {
		return this.s < 0 ? this.negate() : this
	}
	function A(t) {
		var i = this.s - t.s;
		if (i != 0) return i;
		var r = this.t;
		i = r - t.t;
		if (i != 0) return this.s < 0 ? -i : i;
		while (--r >= 0) if ((i = this[r] - t[r]) != 0) return i;
		return 0
	}
	function B(t) {
		var i = 1,
			r;
		if ((r = t >>> 16) != 0) {
			t = r;
			i += 16
		}
		if ((r = t >> 8) != 0) {
			t = r;
			i += 8
		}
		if ((r = t >> 4) != 0) {
			t = r;
			i += 4
		}
		if ((r = t >> 2) != 0) {
			t = r;
			i += 2
		}
		if ((r = t >> 1) != 0) {
			t = r;
			i += 1
		}
		return i
	}
	function M() {
		if (this.t <= 0) return 0;
		return this.DB * (this.t - 1) + B(this[this.t - 1] ^ this.s & this.DM)
	}
	function R(t, i) {
		var r;
		for (r = this.t - 1; r >= 0; --r) i[r + t] = this[r];
		for (r = t - 1; r >= 0; --r) i[r] = 0;
		i.t = this.t + t;
		i.s = this.s
	}
	function x(t, i) {
		for (var r = t; r < this.t; ++r) i[r - t] = this[r];
		i.t = Math.max(this.t - t, 0);
		i.s = this.s
	}
	function V(t, i) {
		var r = t % this.DB;
		var s = this.DB - r;
		var e = (1 << s) - 1;
		var o = Math.floor(t / this.DB),
			n = this.s << r & this.DM,
			h;
		for (h = this.t - 1; h >= 0; --h) {
			i[h + o + 1] = this[h] >> s | n;
			n = (this[h] & e) << r
		}
		for (h = o - 1; h >= 0; --h) i[h] = 0;
		i[o] = n;
		i.t = this.t + o + 1;
		i.s = this.s;
		i.clamp()
	}
	function E(t, i) {
		i.s = this.s;
		var r = Math.floor(t / this.DB);
		if (r >= this.t) {
			i.t = 0;
			return
		}
		var s = t % this.DB;
		var e = this.DB - s;
		var o = (1 << s) - 1;
		i[0] = this[r] >> s;
		for (var n = r + 1; n < this.t; ++n) {
			i[n - r - 1] |= (this[n] & o) << e;
			i[n - r] = this[n] >> s
		}
		if (s > 0) i[this.t - r - 1] |= (this.s & o) << e;
		i.t = this.t - r;
		i.clamp()
	}
	function I(t, i) {
		var r = 0,
			s = 0,
			e = Math.min(t.t, this.t);
		while (r < e) {
			s += this[r] - t[r];
			i[r++] = s & this.DM;
			s >>= this.DB
		}
		if (t.t < this.t) {
			s -= t.s;
			while (r < this.t) {
				s += this[r];
				i[r++] = s & this.DM;
				s >>= this.DB
			}
			s += this.s
		} else {
			s += this.s;
			while (r < t.t) {
				s -= t[r];
				i[r++] = s & this.DM;
				s >>= this.DB
			}
			s -= t.s
		}
		i.s = s < 0 ? -1 : 0;
		if (s < -1) i[r++] = this.DV + s;
		else if (s > 0) i[r++] = s;
		i.t = r;
		i.clamp()
	}
	function O(t, i) {
		var r = this.abs(),
			e = t.abs();
		var o = r.t;
		i.t = o + e.t;
		while (--o >= 0) i[o] = 0;
		for (o = 0; o < e.t; ++o) i[o + r.t] = r.am(0, e[o], i, o, 0, r.t);
		i.s = 0;
		i.clamp();
		if (this.s != t.s) s.ZERO.subTo(i, i)
	}
	function q(t) {
		var i = this.abs();
		var r = t.t = 2 * i.t;
		while (--r >= 0) t[r] = 0;
		for (r = 0; r < i.t - 1; ++r) {
			var s = i.am(r, i[r], t, 2 * r, 0, 1);
			if ((t[r + i.t] += i.am(r + 1, 2 * i[r], t, 2 * r + 1, s, i.t - r - 1)) >= i.DV) {
				t[r + i.t] -= i.DV;
				t[r + i.t + 1] = 1
			}
		}
		if (t.t > 0) t[t.t - 1] += i.am(r, i[r], t, 2 * r, 0, 1);
		t.s = 0;
		t.clamp()
	}
	function N(t, i, r) {
		var o = t.abs();
		if (o.t <= 0) return;
		var n = this.abs();
		if (n.t < o.t) {
			if (i != null) i.fromInt(0);
			if (r != null) this.copyTo(r);
			return
		}
		if (r == null) r = e();
		var h = e(),
			f = this.s,
			a = t.s;
		var u = this.DB - B(o[o.t - 1]);
		if (u > 0) {
			o.lShiftTo(u, h);
			n.lShiftTo(u, r)
		} else {
			o.copyTo(h);
			n.copyTo(r)
		}
		var l = h.t;
		var p = h[l - 1];
		if (p == 0) return;
		var v = p * (1 << this.F1) + (l > 1 ? h[l - 2] >> this.F2 : 0);
		var c = this.FV / v,
			m = (1 << this.F1) / v,
			y = 1 << this.F2;
		var w = r.t,
			T = w - l,
			d = i == null ? e() : i;
		h.dlShiftTo(T, d);
		if (r.compareTo(d) >= 0) {
			r[r.t++] = 1;
			r.subTo(d, r)
		}
		s.ONE.dlShiftTo(l, d);
		d.subTo(h, h);
		while (h.t < l) h[h.t++] = 0;
		while (--T >= 0) {
			var g = r[--w] == p ? this.DM : Math.floor(r[w] * c + (r[w - 1] + y) * m);
			if ((r[w] += h.am(0, g, r, T, 0, l)) < g) {
				h.dlShiftTo(T, d);
				r.subTo(d, r);
				while (r[w] < --g) r.subTo(d, r)
			}
		}
		if (i != null) {
			r.drShiftTo(l, i);
			if (f != a) s.ZERO.subTo(i, i)
		}
		r.t = l;
		r.clamp();
		if (u > 0) r.rShiftTo(u, r);
		if (f < 0) s.ZERO.subTo(r, r)
	}
	function F(t) {
		var i = e();
		this.abs().divRemTo(t, null, i);
		if (this.s < 0 && i.compareTo(s.ZERO) > 0) t.subTo(i, i);
		return i
	}
	function Z(t) {
		this.m = t
	}
	function j(t) {
		if (t.s < 0 || t.compareTo(this.m) >= 0) return t.mod(this.m);
		else return t
	}
	function C(t) {
		return t
	}
	function P(t) {
		t.divRemTo(this.m, null, t)
	}
	function k(t, i, r) {
		t.multiplyTo(i, r);
		this.reduce(r)
	}
	function L(t, i) {
		t.squareTo(i);
		this.reduce(i)
	}
	Z.prototype.convert = j;
	Z.prototype.revert = C;
	Z.prototype.reduce = P;
	Z.prototype.mulTo = k;
	Z.prototype.sqrTo = L;

	function z() {
		if (this.t < 1) return 0;
		var t = this[0];
		if ((t & 1) == 0) return 0;
		var i = t & 3;
		i = i * (2 - (t & 15) * i) & 15;
		i = i * (2 - (t & 255) * i) & 255;
		i = i * (2 - ((t & 65535) * i & 65535)) & 65535;
		i = i * (2 - t * i % this.DV) % this.DV;
		return i > 0 ? this.DV - i : -i
	}
	function K(t) {
		this.m = t;
		this.mp = t.invDigit();
		this.mpl = this.mp & 32767;
		this.mph = this.mp >> 15;
		this.um = (1 << t.DB - 15) - 1;
		this.mt2 = 2 * t.t
	}
	function U(t) {
		var i = e();
		t.abs().dlShiftTo(this.m.t, i);
		i.divRemTo(this.m, null, i);
		if (t.s < 0 && i.compareTo(s.ZERO) > 0) this.m.subTo(i, i);
		return i
	}
	function G(t) {
		var i = e();
		t.copyTo(i);
		this.reduce(i);
		return i
	}
	function H(t) {
		while (t.t <= this.mt2) t[t.t++] = 0;
		for (var i = 0; i < this.m.t; ++i) {
			var r = t[i] & 32767;
			var s = r * this.mpl + ((r * this.mph + (t[i] >> 15) * this.mpl & this.um) << 15) & t.DM;
			r = i + this.m.t;
			t[r] += this.m.am(0, s, t, i, 0, this.m.t);
			while (t[r] >= t.DV) {
				t[r] -= t.DV;
				t[++r]++
			}
		}
		t.clamp();
		t.drShiftTo(this.m.t, t);
		if (t.compareTo(this.m) >= 0) t.subTo(this.m, t)
	}
	function J(t, i) {
		t.squareTo(i);
		this.reduce(i)
	}
	function Q(t, i, r) {
		t.multiplyTo(i, r);
		this.reduce(r)
	}
	K.prototype.convert = U;
	K.prototype.revert = G;
	K.prototype.reduce = H;
	K.prototype.mulTo = Q;
	K.prototype.sqrTo = J;

	function W() {
		return (this.t > 0 ? this[0] & 1 : this.s) == 0
	}
	function X(t, i) {
		if (t > 4294967295 || t < 1) return s.ONE;
		var r = e(),
			o = e(),
			n = i.convert(this),
			h = B(t) - 1;
		n.copyTo(r);
		while (--h >= 0) {
			i.sqrTo(r, o);
			if ((t & 1 << h) > 0) i.mulTo(o, n, r);
			else {
				var f = r;
				r = o;
				o = f
			}
		}
		return i.revert(r)
	}
	function Y(t, i) {
		var r;
		if (t < 256 || i.isEven()) r = new Z(i);
		else r = new K(i);
		return this.exp(t, r)
	}
	s.prototype.copyTo = y;
	s.prototype.fromInt = w;
	s.prototype.fromString = d;
	s.prototype.clamp = g;
	s.prototype.dlShiftTo = R;
	s.prototype.drShiftTo = x;
	s.prototype.lShiftTo = V;
	s.prototype.rShiftTo = E;
	s.prototype.subTo = I;
	s.prototype.multiplyTo = O;
	s.prototype.squareTo = q;
	s.prototype.divRemTo = N;
	s.prototype.invDigit = z;
	s.prototype.isEven = W;
	s.prototype.exp = X;
	s.prototype.toString = D;
	s.prototype.negate = b;
	s.prototype.abs = S;
	s.prototype.compareTo = A;
	s.prototype.bitLength = M;
	s.prototype.mod = F;
	s.prototype.modPowInt = Y;
	s.ZERO = T(0);
	s.ONE = T(1);

	function $() {
		this.i = 0;
		this.j = 0;
		this.S = new Array
	}
	function _(t) {
		var i, r, s;
		for (i = 0; i < 256; ++i) this.S[i] = i;
		r = 0;
		for (i = 0; i < 256; ++i) {
			r = r + this.S[i] + t[i % t.length] & 255;
			s = this.S[i];
			this.S[i] = this.S[r];
			this.S[r] = s
		}
		this.i = 0;
		this.j = 0
	}
	function ti() {
		var t;
		this.i = this.i + 1 & 255;
		this.j = this.j + this.S[this.i] & 255;
		t = this.S[this.i];
		this.S[this.i] = this.S[this.j];
		this.S[this.j] = t;
		return this.S[t + this.S[this.i] & 255]
	}
	$.prototype.init = _;
	$.prototype.next = ti;

	function ii() {
		return new $
	}
	var ri = 256;
	var si;
	var ei;
	var oi;

	function ni(t) {
		ei[oi++] ^= t & 255;
		ei[oi++] ^= t >> 8 & 255;
		ei[oi++] ^= t >> 16 & 255;
		ei[oi++] ^= t >> 24 & 255;
		if (oi >= ri) oi -= ri
	}
	function hi() {
		ni((new Date).getTime())
	}
	if (ei == null) {
		ei = new Array;
		oi = 0;
		var fi;
		if (window.crypto && window.crypto.getRandomValues) {
			var ai = new Uint8Array(32);
			window.crypto.getRandomValues(ai);
			for (fi = 0; fi < 32; ++fi) ei[oi++] = ai[fi]
		}
		if (navigator.appName == "Netscape" && navigator.appVersion < "5" && window.crypto) {
			var ui = window.crypto.random(32);
			for (fi = 0; fi < ui.length; ++fi) ei[oi++] = ui.charCodeAt(fi) & 255
		}
		while (oi < ri) {
			fi = Math.floor(65536 * Math.random());
			ei[oi++] = fi >>> 8;
			ei[oi++] = fi & 255
		}
		oi = 0;
		hi()
	}
	function li() {
		if (si == null) {
			hi();
			si = ii();
			si.init(ei);
			for (oi = 0; oi < ei.length; ++oi) ei[oi] = 0;
			oi = 0
		}
		return si.next()
	}
	function pi(t) {
		var i;
		for (i = 0; i < t.length; ++i) t[i] = li()
	}
	function vi() {}
	vi.prototype.nextBytes = pi;

	function ci(t, i) {
		return new s(t, i)
	}
	function mi(t, i) {
		var r = "";
		var s = 0;
		while (s + i < t.length) {
			r += t.substring(s, s + i) + "\n";
			s += i
		}
		return r + t.substring(s, t.length)
	}
	function yi(t) {
		if (t < 16) return "0" + t.toString(16);
		else return t.toString(16)
	}
	function wi(t, i) {
		if (i < t.length + 11) {
			alert("Message too long for RSA");
			return null
		}
		var r = new Array;
		var e = t.length - 1;
		while (e >= 0 && i > 0) {
			var o = t.charCodeAt(e--);
			if (o < 128) {
				r[--i] = o
			} else if (o > 127 && o < 2048) {
				r[--i] = o & 63 | 128;
				r[--i] = o >> 6 | 192
			} else {
				r[--i] = o & 63 | 128;
				r[--i] = o >> 6 & 63 | 128;
				r[--i] = o >> 12 | 224
			}
		}
		r[--i] = 0;
		var n = new vi;
		var h = new Array;
		while (i > 2) {
			h[0] = 0;
			while (h[0] == 0) n.nextBytes(h);
			r[--i] = h[0]
		}
		r[--i] = 2;
		r[--i] = 0;
		return new s(r)
	}
	function Ti() {
		this.n = null;
		this.e = 0;
		this.d = null;
		this.p = null;
		this.q = null;
		this.dmp1 = null;
		this.dmq1 = null;
		this.coeff = null
	}
	function di(t, i) {
		if (t != null && i != null && t.length > 0 && i.length > 0) {
			this.n = ci(t, 16);
			this.e = parseInt(i, 16)
		} else alert("Invalid RSA public key")
	}
	function gi(t) {
		return t.modPowInt(this.e, this.n)
	}
	function Di(t) {
		var i = wi(t, this.n.bitLength() + 7 >> 3);
		if (i == null) return null;
		var r = this.doPublic(i);
		if (r == null) return null;
		var s = r.toString(16);
		if ((s.length & 1) == 0) return s;
		else return "0" + s
	}
	Ti.prototype.doPublic = gi;
	Ti.prototype.setPublic = di;
	Ti.prototype.encrypt = Di;
	var bi = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/";
	var Si = "=";

	function Ai(t) {
		var i;
		var r;
		var s = "";
		for (i = 0; i + 3 <= t.length; i += 3) {
			r = parseInt(t.substring(i, i + 3), 16);
			s += bi.charAt(r >> 6) + bi.charAt(r & 63)
		}
		if (i + 1 == t.length) {
			r = parseInt(t.substring(i, i + 1), 16);
			s += bi.charAt(r << 2)
		} else if (i + 2 == t.length) {
			r = parseInt(t.substring(i, i + 2), 16);
			s += bi.charAt(r >> 2) + bi.charAt((r & 3) << 4)
		}
		while ((s.length & 3) > 0) s += Si;
		return s
	}
	function Bi(t) {
		var i = "";
		var r;
		var s = 0;
		var e;
		for (r = 0; r < t.length; ++r) {
			if (t.charAt(r) == Si) break;
			v = bi.indexOf(t.charAt(r));
			if (v < 0) continue;
			if (s == 0) {
				i += c(v >> 2);
				e = v & 3;
				s = 1
			} else if (s == 1) {
				i += c(e << 2 | v >> 4);
				e = v & 15;
				s = 2
			} else if (s == 2) {
				i += c(e);
				i += c(v >> 2);
				e = v & 3;
				s = 3
			} else {
				i += c(e << 2 | v >> 4);
				i += c(v & 15);
				s = 0
			}
		}
		if (s == 1) i += c(e << 2);
		return i
	}
	function Mi(t) {
		var i = Bi(t);
		var r;
		var s = new Array;
		for (r = 0; 2 * r < i.length; ++r) {
			s[r] = parseInt(i.substring(2 * r, 2 * r + 2), 16)
		}
		return s
	}
	window.RSA = {
		RSAKey: Ti,
		linebrk: mi,
		hex2b64: Ai,
		b64tohex: Bi
	}
})();
